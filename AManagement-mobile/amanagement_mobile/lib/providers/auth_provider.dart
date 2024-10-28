import 'dart:convert';
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

  Future<void> register(
  String name,
  String email,
  String password,
  String nickName,
  String middleName,
  String lastName,
  final selectedGender,
  String contactNumber,
  String address,
  String gcashNumber,
) async {
  if (name.isEmpty || email.isEmpty || password.isEmpty || nickName.isEmpty || middleName.isEmpty || lastName.isEmpty || selectedGender.isEmpty
      || contactNumber.isEmpty || address.isEmpty || gcashNumber.isEmpty) {
    throw Exception('Name, email, and other fields are required');
  }

  try {
    final registrationData = {
      'name': name,
      'email': email,
      'password': password,
      'nickname': nickName,
      'middlename': middleName,
      'lastname': lastName,
      'gender': selectedGender,
      'contact_number': contactNumber,
      'address': address,
      'gcash_number': gcashNumber,
    };

    print('Registering user with data: ${json.encode(registrationData)}');

    // Call API and parse the response
    final response = await apiService.registerUser(
      name,
      email,
      password,
      nickName,
      middleName,
      lastName,
      selectedGender,
      contactNumber,
      address,
      gcashNumber,
    );

    if (response != null) {
      _user = response;  // Assuming response is of type User
      _token = _user?.token ?? '';  // Provide default if null
      _isLoggedIn = true;
      notifyListeners();
    } else {
      throw Exception('Registration failed, no user returned');
    }
  } catch (e) {
    // print("Registration Error: $e");
    // throw e;  // Rethrow the error for handling in the UI
  }
}
}
