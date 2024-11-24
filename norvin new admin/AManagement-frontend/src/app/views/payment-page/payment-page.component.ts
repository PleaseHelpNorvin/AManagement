import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
// import { provideHttpClient } from '@angular/common/http';
@Component({
  selector: 'app-payment-page',
  standalone: true,
  imports: [CommonModule,FormsModule],
  templateUrl: './payment-page.component.html',
  styleUrls: ['./payment-page.component.css']
})
export class PaymentPageComponent {
  payments = [
    { tenantName: 'John Doe', amountPaid: 5000, date: new Date('2024-11-01'), paymentMethod: 'GCash', status: 'paid' },
    { tenantName: 'Jane Smith', amountPaid: 0, date: new Date('2024-11-10'), paymentMethod: 'GCash', status: 'pending' },
    { tenantName: 'Jane Smith', amountPaid: 0, date: new Date('2024-11-10'), paymentMethod: 'GCash', status: 'pending' },
    { tenantName: 'Jane Smith', amountPaid: 0, date: new Date('2024-11-10'), paymentMethod: 'GCash', status: 'pending' },

    { tenantName: 'Sam Green', amountPaid: 0, date: new Date('2024-10-20'), paymentMethod: 'GCash', status: 'overdue' },
  ];

  filteredPayments = this.payments;
  paidCount = 0;
  pendingCount = 0;
  overdueCount = 0;

  startDate!: string;
  endDate!: string;

  constructor(private http: HttpClient) {
    this.calculateStatusCounts();
  }

  calculateStatusCounts() {
    this.paidCount = this.payments.filter(payment => payment.status === 'paid').length;
    this.pendingCount = this.payments.filter(payment => payment.status === 'pending').length;
    this.overdueCount = this.payments.filter(payment => payment.status === 'overdue').length;
  }

  filterPayments(status: string) {
    if (status === 'all') {
      this.filteredPayments = this.payments;
    } else {
      this.filteredPayments = this.payments.filter(payment => payment.status === status);
    }
  }

  generateReport() {
    if (!this.startDate || !this.endDate) {
      alert('Please select a start and end date.');
      return;
    }

    const report = this.payments.filter(payment => {
      const paymentDate = new Date(payment.date).getTime();
      return paymentDate >= new Date(this.startDate).getTime() && paymentDate <= new Date(this.endDate).getTime();
    });

    console.log('Generated Report:', report);
    alert('Report generated. Check console for details.');
  }

  sendReminders() {
    const overduePayments = this.payments.filter(payment => payment.status === 'overdue');
    if (overduePayments.length === 0) {
      alert('No overdue payments to remind.');
      return;
    }

    console.log('Sending reminders for:', overduePayments);
    alert('Reminders sent for overdue payments.');
  }
}
