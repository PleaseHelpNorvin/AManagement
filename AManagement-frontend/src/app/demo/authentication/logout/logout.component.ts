import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthenticationService } from 'src/app/theme/shared/services/authentication/authentication.service';
import { AuthStateService } from 'src/app/theme/shared/services/authentication/state/authe-state-service.service';
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
    private iconService: IconService,
    private authState: AuthStateService
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
      title: 'Are you sure?',
      text: 'Do you want to log out?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, log me out',
      cancelButtonText: 'Cancel',
    }).then((result) => {
      if (result.isConfirmed) {
        console.log('User confirmed logout. Proceeding to logout...');
        this.authService.logout().subscribe({
          next: () => {
            console.log('Logout successful. Clearing token and redirecting to login.');
            this.authState.setAuthenticated(false);
            window.location.href = '/login';
          },
          error: (err) => {
            console.error('Logout failed:', err);
            Swal.fire({
              title: 'Error',
              text: 'Logout failed. You may need to refresh the page.',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        });
      } else {
        console.log('User canceled logout.');
      }
    });

  }
}
