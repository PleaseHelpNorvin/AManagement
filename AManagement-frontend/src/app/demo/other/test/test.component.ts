import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TestService, Apartment  } from './service/test.service';


@Component({
  selector: 'app-test',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './test.component.html',
  styleUrl: './test.component.scss'
})
export default class TestComponent {

  constructor(private testService: TestService){}

  apartment!: Apartment[];
  selectedApartment: Apartment | null = null;

  ngOnInit(){
    this.getApartments();
  }

  //FETCH ALL APARTMENT
  getApartments() {
    this.testService.getApartments().subscribe((res) => {
      console.log(res);
      this.apartment = res;
    });
  }

  // FETCH SELECTED APARTMENT
  getApartment(id: number) {
    this.testService.getApartment(id).subscribe((res) => {
      this.selectedApartment = res;
    });
  }

  addApartment(newApartment: Apartment) {
    this.testService.addApartment(newApartment).subscribe((res) => {
      this.apartment.push(res);
    });
  }

  updateApartment(id: number, updatedApartment: Apartment) {
    this.testService.updateApartment(id, updatedApartment).subscribe((res) => {
      const index = this.apartment.findIndex(apartment => apartment.apartment_id === id);
      if (index !== -1) {
        this.apartment[index] = res;
      }
    });
  }

  deleteApartment(id: number) {
    this.testService.deleteApartment(id).subscribe(() => {
      this.apartment = this.apartment.filter(apartment => apartment.apartment_id !== id);
    });
  }
}
