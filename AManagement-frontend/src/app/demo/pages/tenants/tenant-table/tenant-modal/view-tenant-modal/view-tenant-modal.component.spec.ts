import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ViewTenantModalComponent } from './view-tenant-modal.component';

describe('ViewTenantModalComponent', () => {
  let component: ViewTenantModalComponent;
  let fixture: ComponentFixture<ViewTenantModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ViewTenantModalComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ViewTenantModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
