import 'package:flutter/material.dart';
import 'pages/login.dart';  // Your login page

class MainApp extends StatelessWidget {
  const MainApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      theme: ThemeData.from(
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color.fromRGBO(32, 63, 129, 1.0),
        ),
      ),
      home: const Login(),  // Navigate directly to the Login screen
    );
  }
}
//  print('Auth Token: $authToken');
//           print('User ID: $userId');  