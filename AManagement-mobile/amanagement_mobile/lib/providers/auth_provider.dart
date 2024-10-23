// import 'services/api_service.dart';
import 'package:flutter/material.dart';

import '../services/api_service.dart';
import '../models/user.dart';

class AuthProvider extends ChangeNotifier{
  final ApiService apiService;
  AuthProvider(this.apiService);

  User? _user;
  String _token = '';
  bool _isLoggedIn = false;

  User? get user => _user;
  String get token => _token;
  bool get isLoggedIn => _isLoggedIn;


  Future<void> register(String name, String email, String password) async {
    try {
      _user = await apiService.registerUser(name, email, password);
      // Additional logic to handle successful registration (e.g., save token)
      if (_user != null) {
        _token = _user!.token;
        _isLoggedIn = true;
        // Notify listeners about the state change
        notifyListeners();
      }
    } catch (e) {
      // Handle registration error
      print("Registration Error: $e");
    }
  }


  Future<void> login(String email, String password) async {
    try {
      _user = await apiService.login(email, password);
      if(_user != null) {
        _user = null;
        _token = '';
        _isLoggedIn = false;

        notifyListeners();
      }
    } catch (e) {
      print("Login Error: $e");
    }
  }
}
