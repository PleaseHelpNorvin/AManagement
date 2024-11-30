import 'package:flutter/material.dart';
import 'package:amanagement_mobile/screens/register1.dart'; // Import the screen

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Register1(), // Use the imported screen here
    );
  }
}
