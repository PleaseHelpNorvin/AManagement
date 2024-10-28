import 'package:amanagement_mobile/screens/dashboard_screen.dart';
import 'package:amanagement_mobile/services/api_service.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import './providers/auth_provider.dart';
import './screens/register_screen.dart'; // Ensure correct path
import './screens/dashboard_screen.dart';

void main() {
  runApp(
    ChangeNotifierProvider(
      create: (_) => AuthProvider(ApiService()), // Provide the ApiService instance
      child: MyApp(),
    ),
  );
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Apartment Management',
      theme: ThemeData(
        primarySwatch: Colors.blue,
      ),
      initialRoute: '/register',
      routes: {
        '/register': (context) => RegisterScreen(),
        '/dashboard': (context) => DashboardScreen(token:'' , role: '', name:''), // Assuming you have a HomePage widget
      },
    );
  }
}

