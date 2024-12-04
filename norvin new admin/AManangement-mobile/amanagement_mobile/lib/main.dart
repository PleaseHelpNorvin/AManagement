import 'package:flutter/material.dart';
import 'package:amanagement_mobile/screens/register/register1.dart';
// import 'package:amanagement_mobile/screens/register/register2.dart';
// import 'package:amanagement_mobile/screens/contract/contract1.dart';
// import 'package:amanagement_mobile/screens/contract/contract2.dart';
// import 'package:amanagement_mobile/screens/contract/contract3.dart';
// import 'package:amanagement_mobile/screens/contract/contract4.dart';
void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      
      home:Register1(),
    );
  }
}
//  home: CreateUserProfileScreen(
//          email: "test@example.com",  // Static email for now
//         password: "testpassword",   // Static password for now
//       ),