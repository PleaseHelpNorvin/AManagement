import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';  // Import CommonModule
import { ChatService  } from '../service/chat.service';

@Component({
  selector: 'app-chat',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './chat.component.html',
  styleUrl: './chat.component.scss'
})
export class ChatComponent {
  sidebarVisible: boolean = false;
  tenants: any[] = [];
  selectedTenant: any = null;
  messages: string[] = [];
  messageText: string = '';

  constructor(private chatService: ChatService) {}
  toggleSidebar(): void {
    this.sidebarVisible = !this.sidebarVisible;
  }

  ngOnInit(): void {
    // Fetch tenants when the component is initialized
    this.chatService.getTenants().subscribe((tenants) => {
      this.tenants = tenants;
    });
  }

  selectTenant(tenant: any): void {
    this.selectedTenant = tenant;
    // Fetch messages for the selected tenant
    this.chatService.getMessages(tenant.id).subscribe((messages) => {
      this.messages = messages;
    });
  }

  sendMessage(): void {
    if (this.messageText.trim()) {
      this.chatService.sendMessage(this.selectedTenant.id, this.messageText).subscribe((message) => {
        this.messages.push(message); // Add new message to the messages array
        this.messageText = ''; // Clear the input field
      });
    }
  }
}
