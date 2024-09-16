import { Component } from '@angular/core';

import { SharedModule } from 'src/app/theme/shared/shared.module';

@Component({
  selector: 'app-test-file',
  standalone: true,
  imports: [SharedModule],
  templateUrl: './test-file.component.html',
  styleUrl: './test-file.component.scss'
})
export default class TestFileComponent {
  
}
