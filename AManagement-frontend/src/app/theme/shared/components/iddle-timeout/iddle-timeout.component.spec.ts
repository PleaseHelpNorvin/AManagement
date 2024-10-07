import { ComponentFixture, TestBed } from '@angular/core/testing';

import { IddleTimeoutComponent } from './iddle-timeout.component';

describe('IddleTimeoutComponent', () => {
  let component: IddleTimeoutComponent;
  let fixture: ComponentFixture<IddleTimeoutComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [IddleTimeoutComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(IddleTimeoutComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
