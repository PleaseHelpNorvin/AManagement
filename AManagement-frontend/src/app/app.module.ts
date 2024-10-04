// angular import
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http'; 

// project import
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SharedModule } from './theme/shared/shared.module';

//other inmport
import { QRCodeModule } from 'angularx-qrcode';
import QrComponent from "./demo/other/qr/qr.component"
import { FormsModule } from '@angular/forms';
import {QrCodeComponent}  from './demo/other/qr/qr-code/qr-code.component';

@NgModule({
  declarations: [AppComponent],
  imports: [BrowserModule, AppRoutingModule, SharedModule, BrowserAnimationsModule, HttpClientModule ,QRCodeModule, FormsModule,QrComponent ,QrCodeComponent],
  // providers:[],
  bootstrap: [AppComponent]
})
export class AppModule {}
