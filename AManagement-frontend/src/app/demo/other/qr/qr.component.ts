import { Component } from '@angular/core';
import { QrCodeComponent } from './qr-code/qr-code.component';
// import { QRCodeModule } from '@angular/forms';

@Component({
  selector: 'app-qr',
  standalone: true,
  imports: [QrCodeComponent],
  templateUrl: './qr.component.html',
  styleUrl: './qr.component.scss'
})
export default class QrComponent {
  
}
