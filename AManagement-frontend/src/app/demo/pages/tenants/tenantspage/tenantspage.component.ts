import { Component } from '@angular/core';
import { TenantTableComponent } from '../tenant-table/tenant-table.component';


@Component({
  selector: 'app-tenantspage',
  standalone: true,
  imports: [TenantTableComponent],
  templateUrl: './tenantspage.component.html',
  styleUrl: './tenantspage.component.scss'
})
export default class TenantspageComponent {

}
