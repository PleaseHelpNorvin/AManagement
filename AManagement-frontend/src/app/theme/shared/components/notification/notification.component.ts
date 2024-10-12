import { Component, OnInit } from '@angular/core';
import { NotificationService } from '../../services/notifications/notification.service';
import { CommonModule } from '@angular/common'; 

@Component({
  selector: 'app-notification',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './notification.component.html',
  styleUrls: ['./notification.component.scss'] 
})
export class NotificationComponent {
  message: string | null = null;
  
  constructor(private notificationService: NotificationService){}

  ngOnInit() {
    this.notificationService.getNotification().subscribe((message) => {
      this.message = message;
      setTimeout(() => this.message = null, 5000); // Clear message after 5 seconds
    });
  }
}
