import { ComponentFixture, TestBed } from '@angular/core/testing';
import LogoutComponent from './logout.component';
import { CommonModule } from '@angular/common'; // Import necessary modules

describe('LogoutComponent', () => {
  let component: LogoutComponent;
  let fixture: ComponentFixture<LogoutComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [LogoutComponent], // Use 'declarations' instead of 'imports'
      imports: [CommonModule] // Import any necessary Angular modules
    })
    .compileComponents();

    fixture = TestBed.createComponent(LogoutComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
