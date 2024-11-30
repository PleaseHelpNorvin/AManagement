import 'package:flutter/material.dart';
import 'package:amanagement_mobile/screens/register1.dart'; // Import the screen
import 'package:amanagement_mobile/screens/register2.dart';
import 'package:amanagement_mobile/screens/register3.dart';
void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Register3(
         email: "test@example.com",  // Static email for now
        password: "testpassword",   // Static password for now
      ), // Use the imported screen here
      // home:
    );
  }
}
//  home: CreateUserProfileScreen(
//          email: "test@example.com",  // Static email for now
//         password: "testpassword",   // Static password for now
//       ),