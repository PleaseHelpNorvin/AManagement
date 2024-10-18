import { ComponentFixture, TestBed } from '@angular/core/testing';

// Update this import statement to use the default import
import QrcodepageComponent from '../qrcodepage/qrcodepage.component';
import { QrcodeComponent } from '../qrcode/qrcode.component';

describe('QrcodepageComponent', () => {
  let component: QrcodepageComponent;
  let fixture: ComponentFixture<QrcodepageComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [QrcodepageComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(QrcodepageComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
