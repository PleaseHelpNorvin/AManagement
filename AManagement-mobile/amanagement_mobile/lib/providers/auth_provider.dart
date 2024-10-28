import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/user.dart';

class AuthProvider extends ChangeNotifier {
  final ApiService apiService;

  AuthProvider(this.apiService);

  User? _user;
  String _token = '';
  bool _isLoggedIn = false;

  User? get user => _user;
  String get token => _token;
  bool get isLoggedIn => _isLoggedIn;

  Future<void> register(String name, String email, String password, String nickName, String middleName, String lastName, String selectedGender, String contactNumber, String address, String gcashNumber ) async {
    try {
      _user = await apiService.registerUser( name, email,
        password,
        nickName,
        middleName,
        lastName,
        selectedGender,
        contactNumber,
        address,
        gcashNumber,
      );
      if (_user != null) {
        _token = _user!.token;  // Save the token
        _isLoggedIn = true;      // Update logged-in status
        notifyListeners();       // Notify listeners
      }
    } catch (e) {
      print("Registration Error: $e");
      throw e;  // Rethrow the error for handling in the UI
    }
  }
}
