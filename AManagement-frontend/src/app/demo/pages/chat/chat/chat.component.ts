import { Component } from '@angular/core';
import { CommonModule } from '@angular/common'; // Import CommonModule
import { FormsModule } from '@angular/forms'; // Import FormsModule
import { ChatService } from '../service/chat.service';

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

  constructor(private chatService: ChatService) {}

  toggleSidebar(): void {
    this.sidebarVisible = !this.sidebarVisible;
  }

  ngOnInit(): void {
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
  }

  sendMessage(): void {
    if (this.messageText.trim() && this.selectedTenant) {
      this.chatService.sendMessage(this.selectedTenant.id, this.messageText).subscribe(
        (message) => {
          this.messages.push(message); // Add new message to the messages array
          this.messageText = ''; // Clear the input field
        },
        (error) => {
          console.error('Error sending message:', error);
        }
      );
    }
  }
}
