import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

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
  selector: 'app-chat-page',
  imports: [CommonModule, FormsModule],
  templateUrl: './chat-page.component.html',
  styleUrl: './chat-page.component.css'
})
export class ChatPageComponent {
  sidebarVisible: boolean = false;

  // Static data for tenants
  tenants: Tenant[] = [
    { id: 1, name: 'Tenant 1' },
    { id: 2, name: 'Tenant 2' },
    { id: 3, name: 'Tenant 3' },
  ];

  // Placeholder for messages
  messages: Message[] = [];

  // Selected tenant
  selectedTenant: Tenant | null = null;

  // Input message
  messageText: string = '';

  constructor() {}

  toggleSidebar(): void {
    this.sidebarVisible = !this.sidebarVisible;
  }

  ngOnInit(): void {
    console.log('ChatComponent with static data initialized');
  }

  selectTenant(tenant: Tenant): void {
    this.selectedTenant = tenant;

    // Static messages for each tenant
    this.messages = [
      { id: 1, sender: 'Tenant ' + tenant.id, text: 'Hello!' },
      { id: 2, sender: 'Admin', text: `Hi ${tenant.name}, how can I help you?` },
    ];
  }

  sendMessage(): void {
    if (this.messageText.trim() && this.selectedTenant) {
      // Add the new message to the messages array
      this.messages.push({
        id: this.messages.length + 1,
        sender: 'Admin',
        text: this.messageText.trim(),
      });

      // Clear the input field
      this.messageText = '';
    }
  }
}
