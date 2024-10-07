import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TenantspageComponent } from './tenantspage.component';

describe('TenantspageComponent', () => {
  let component: TenantspageComponent;
  let fixture: ComponentFixture<TenantspageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [TenantspageComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(TenantspageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
