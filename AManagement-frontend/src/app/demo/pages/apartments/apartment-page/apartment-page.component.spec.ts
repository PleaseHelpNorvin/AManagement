import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ApartmentPageComponent } from './apartment-page.component';

describe('ApartmentPageComponent', () => {
  let component: ApartmentPageComponent;
  let fixture: ComponentFixture<ApartmentPageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ApartmentPageComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ApartmentPageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
