import 'package:flutter/material.dart';
import '../theme/colors.dart';

PreferredSizeWidget getAppBarWithoutBackButton(String title) {


  return AppBar(
    title: Text(title),
    centerTitle: true, // Center the title
    elevation: 0, // Set elevation if you want a flat appearance
    backgroundColor: AppColors.appBarColor); // Change to your desired color
  //   actions: [
  //     // You can add action buttons here if needed
  //     IconButton(
  //       icon: const Icon(Icons.notifications),
  //       onPressed: () {
  //         // Handle notification action
  //       },
  //     ),
  //   ],
  // );
}
