import { Component } from '@angular/core';
import { CommonModule } from '@angular/common'; // Import CommonModule
import { FormsModule } from '@angular/forms'; // Import FormsModule
import { ChatService } from '../service/chat.service';
import { BroadcastService } from '../../../../theme/shared/services/laravel-echo/broadcast.service';

interface Tenant {
  id: number;
  name: string;
}

interface Message {
  id: number;
  sender: string;
  text: string;
}

@Component({
  selector: 'app-chat',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss'] // Correct plural spelling
})
export class ChatComponent {
  sidebarVisible: boolean = false;
  tenants: Tenant[] = [];
  selectedTenant: Tenant | null = null;
  messages: Message[] = [];
  messageText: string = '';

  constructor(private broadcastService: BroadcastService, private chatService: ChatService) {}

  toggleSidebar(): void {
    this.sidebarVisible = !this.sidebarVisible;
  }

  ngOnInit(): void {
    console.log('chatcomponent reached');
    // Fetch tenants when the component is initialized
    this.chatService.getTenants().subscribe(
      (tenants) => {
        this.tenants = tenants;
      },
      (error) => {
        console.error('Error fetching tenants:', error);
      }
    );
  }

  selectTenant(tenant: Tenant): void {
    this.selectedTenant = tenant;

    // Fetch messages for the selected tenant
    this.chatService.getMessages(tenant.id).subscribe(
      (messages) => {
        this.messages = messages;
      },
      (error) => {
        console.error('Error fetching messages:', error);
      }
    );

    // Start listening to the tenant's private channel for new messages
    if (tenant) {
      this.broadcastService.listenForBroadcasts(tenant.id);
    }
  }

  sendMessage(): void {
    if (this.messageText.trim() && this.selectedTenant) {
      this.chatService.sendMessage(this.selectedTenant.id, this.messageText).subscribe(
        (message) => {
          // Add new message to the messages array
          this.messages.push(message);
          this.messageText = ''; // Clear the input field
        },
        (error) => {
          console.error('Error sending message:', error);
        }
      );
    }
  }

  ngOnDestroy(): void {
    // Clean up by stopping listening when the component is destroyed
    if (this.selectedTenant) {
      this.broadcastService.stopListening(this.selectedTenant.id);
    }
  }
}
