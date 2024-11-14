import 'dart:convert';

import 'package:amanagement_flutter/model/authmodels/user.dart';
import 'package:amanagement_flutter/pages/clientdatasignup.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'pages/login.dart';
import 'pages/signup.dart';
import 'pages/isfirsttime.dart';
import 'pages/home.dart';

class MainApp extends StatefulWidget {
  const MainApp({super.key});

  @override
  _MainAppState createState() => _MainAppState();
}

class _MainAppState extends State<MainApp> {
  late Future<Widget> _initialScreen;

  @override
  void initState() {
    super.initState();
    _initialScreen = _getInitialScreen();  // Initialize the future to determine the initial screen
  }

  Future<Widget> _getInitialScreen() async {
    final prefs = await SharedPreferences.getInstance();
    final isFirstTimeUser = prefs.getBool('isFirstTimeUser') ?? true;
    final isLoggedIn = prefs.getBool('isLoggedIn') ?? false;
    final isFinishCreatingAccount = prefs.getBool('createdAccount')?? false;

    // If it's the user's first time, show the FirstTimePage
    if (isFirstTimeUser) {
      return const FirstTimePage();
    }

    if(isFinishCreatingAccount) {
      // return const ClientDataSignup();
    }

    // If the user is logged in, navigate to the Home page
    if (isLoggedIn) {
      final userId = prefs.getInt('userId') ?? 0;
      final token = prefs.getString('token') ?? '';
      final userInfoString = prefs.getString('userInfo') ?? '{}';
      final clientInfoString = prefs.getString('clientInfo') ?? '{}';

      // Deserialize userInfo and clientInfo
      final userInfo = UserInfo.fromJson(jsonDecode(userInfoString));
      final clientInfo = ClientInfo.fromJson(jsonDecode(clientInfoString));

      return Home(
        userId: userId,
        token: token,
        userInfo: userInfo,
        clientInfo: clientInfo,
      );
    }
    // If not logged in, navigate to the login page
    return const Login();
  }

  @override
  Widget build(context) {
    return MaterialApp(
      theme: ThemeData.from(
        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color.fromRGBO(32, 63, 129, 1.0),
        ),
      ),
      home: FutureBuilder<Widget>(
        future: _initialScreen,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());  // Show loading indicator while waiting
          } else if (snapshot.hasError) {
            return const Center(child: Text('Error loading screen'));
          } else if (snapshot.hasData) {
            return snapshot.data!;  // Return the determined screen
          } else {
            return const Center(child: Text('No screen found'));
          }
        },
      ),
    );
  }
}
