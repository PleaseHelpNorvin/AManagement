import { Component } from '@angular/core';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import {QRCodeModule } from 'angularx-qrcode';
// import { BrowserModule } from '@angular';

@Component({
  selector: 'app-qr-code',
  standalone: true,
  imports: [FormsModule, QRCodeModule],
  templateUrl: './qr-code.component.html',
  styleUrl: './qr-code.component.scss'
})
export class QrCodeComponent {
  qrData: string = 'https://www.youtube.com/'; 
}
