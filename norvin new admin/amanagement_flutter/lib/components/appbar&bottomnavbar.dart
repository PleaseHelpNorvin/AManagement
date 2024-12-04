import 'package:flutter/material.dart';
class CommonScaffold extends StatelessWidget {
  final int selectedIndex;
  final Function(int) onItemTapped;
  final Widget body;
  final String? appBarTitle; // Add a title parameter

  CommonScaffold({
    required this.selectedIndex,
    required this.onItemTapped,
    required this.body,
    this.appBarTitle, // Initialize it as optional
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(appBarTitle ?? 'AppName'), // Use the custom title or fallback to "AppName"
        backgroundColor: Colors.blue,
      ),
      body: body,
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: selectedIndex,
        onTap: onItemTapped,
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(
            icon: Icon(Icons.home),
            label: 'Home',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.notifications),
            label: 'Notifications',
          ),
        ],
      ),
    );
  }
}
