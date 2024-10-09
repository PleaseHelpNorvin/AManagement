import { Component } from '@angular/core';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { QRCodeModule } from 'angularx-qrcode';
// import { QrcodeComponent } from './qrcode.component';

@Component({
  selector: 'app-qrcode',
  standalone: true,
  imports: [SharedModule],
  templateUrl: './qrcode.component.html',
  styleUrl: './qrcode.component.scss'
})
export class QrcodeComponent {
  qrData: string = 'https://www.youtube.com/';
}
