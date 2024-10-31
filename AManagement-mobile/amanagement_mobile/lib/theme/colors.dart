import 'package:flutter/material.dart';

class AppColors {
  static const Color primaryColor = Color(0xFF2196F3);
  static const Color secondaryColor = Color(0xFFFFC107);
  static const Color errorColor = Color(0xFFf44336);
  static Color appBarColor = Color.fromARGB(255, 148, 235, 255);
  // Add more colors as needed
}


// class HexColor extends Color {
//   // Constructor that takes a hex string and converts it to a Color object
//   HexColor(String hexColor) : super(_getColorFromHex(hexColor));

//   // Method to convert hex string to Color value
//   static int _getColorFromHex(String hexColor) {
//     // Check for hash (#) prefix and remove it
//     hexColor = hexColor.replaceAll('#', '');
//     if (hexColor.length == 6) {
//       hexColor = 'FF' + hexColor; // Add alpha value if not provided
//     }
//     return int.parse(hexColor, radix: 16);
//   }
// }