import { Component } from '@angular/core';
import { QrcodeComponent } from '../qrcode/qrcode.component';
@Component({
  selector: 'app-qrcodepage',
  standalone: true,
  imports: [QrcodeComponent],
  templateUrl: './qrcodepage.component.html',
  styleUrl: './qrcodepage.component.scss'
})
export default class QrcodepageComponent {

}
