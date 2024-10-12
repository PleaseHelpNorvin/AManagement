import 'package:flutter/material.dart';
import '../models/user.dart';

class DashboardScreen extends StatelessWidget {
  final User user;

  DashboardScreen({required this.user});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Dashboard')),
      body: Center(
        child: Text('Welcome, ${user.username}!'),
      ),
    );
  }
}
