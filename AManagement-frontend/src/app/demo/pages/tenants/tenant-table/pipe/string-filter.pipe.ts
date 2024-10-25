import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'stringFilter',
  standalone: true // Optional if you use standalone components
})
export class StringFilterPipe implements PipeTransform {
  transform(items: any[], searchText: string): any[] {
    if (!items || !searchText) {
      return items;
    }
    // Apply filtering based on searchText
    return items.filter(item => {
      const fullName = `${item.firstname} ${item.lastname}`.toLowerCase();
      return fullName.includes(searchText.toLowerCase());
    });
  }
}
