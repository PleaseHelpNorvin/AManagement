// import 'services/api_service.dart';
import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../models/user.dart';

class AuthProvider extends ChangeNotifier {
  final ApiService apiService;
  AuthProvider(this.apiService);

  User? _user;
  String get token => _user?.token ?? ''; // Get token from User
  bool get isLoggedIn => _user?.isLoggedIn ?? false; // Check login status

  User? get user => _user;

  Future<void> register(String name, String email, String password) async {
    try {
      _user = await apiService.registerUser(name, email, password);
      if (_user != null) {
        notifyListeners(); // Notify listeners
      }
    } catch (e) {
      print("Registration Error: $e");
    }
  }

  Future<void> login(String username, String password) async {
    try {
      _user = await apiService.login(username, password);
      if (_user != null) {
        notifyListeners(); // Notify listeners
      } else {
        _user = null; // Reset user if login failed
        notifyListeners(); // Notify listeners
      }
    } catch (e) {
      print("Login Error: $e");
    }
  }
}
