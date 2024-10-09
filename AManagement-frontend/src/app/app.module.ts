// angular import
import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

// project import
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { SharedModule } from './theme/shared/shared.module';

//norvinimports
import { AuthenticationService } from './theme/shared/services/authentication/authentication.service';
import { IddleTimeoutService } from './theme/shared/services/iddle-timeout/iddle-timeout.service';
import { HttpClientModule } from '@angular/common/http'; // Import HttpClientModule
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { QRCodeModule }  from 'angularx-qrcode'; 




@NgModule({
  declarations: [AppComponent],
  imports: [BrowserModule, AppRoutingModule, SharedModule, BrowserAnimationsModule, CommonModule, HttpClientModule, FormsModule, QRCodeModule ],
  providers: [ AuthenticationService, IddleTimeoutService ],
  bootstrap: [AppComponent]
})
export class AppModule {}
