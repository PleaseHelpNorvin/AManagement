import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthenticationService } from 'src/app/theme/shared/services/authentication/authentication.service';
import Swal from 'sweetalert2';
import { IconService } from '@ant-design/icons-angular';
import { SharedModule } from 'src/app/theme/shared/shared.module';
import {
  BellOutline,
  SettingOutline,
  GiftOutline,
  MessageOutline,
  PhoneOutline,
  CheckCircleOutline,
  LogoutOutline,
  EditOutline,
  UserOutline,
  ProfileOutline,
  WalletOutline,
  QuestionCircleOutline,
  LockOutline,
  CommentOutline,
  UnorderedListOutline,
  ArrowRightOutline,
  GithubOutline
} from '@ant-design/icons-angular/icons';


@Component({
  selector: 'app-logout',
  standalone: true,
  imports: [SharedModule],
  templateUrl: './logout.component.html',
  styleUrl: './logout.component.scss'
})
export class LogoutComponent {
  constructor(
    private authService: AuthenticationService, 
    private router: Router,
    private iconService: IconService
    ) {
      this.iconService.addIcon(...[
        CheckCircleOutline,
        GiftOutline,
        MessageOutline,
        SettingOutline,
        PhoneOutline,
        LogoutOutline,
        UserOutline,
        EditOutline,
        ProfileOutline,
        QuestionCircleOutline,
        LockOutline,
        CommentOutline,
        UnorderedListOutline,
        ArrowRightOutline,
        BellOutline,
        GithubOutline,
        WalletOutline
      ]);
    }

  logout(): void{
    Swal.fire({
      title: 'Logged Out',
      text: 'You have successfully logged out.',
      icon: 'success',
      confirmButtonText: 'OK',
    }).then (() => {
      this.authService.logout().subscribe();      
    });

    }
}
