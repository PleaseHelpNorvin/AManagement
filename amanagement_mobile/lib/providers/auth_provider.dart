import 'package:flutter/material.dart';
import '../models/user.dart';
import '../services/api_service.dart';

class AuthProvider with ChangeNotifier {
  User? _user;
  final ApiService _apiService = ApiService();

  User? get user => _user;

  Future<void> login(String username, String password) async {
    _user = await _apiService.login(username, password);
    notifyListeners();
  }

  Future<void> register(String username, String password) async {
    _user = await _apiService.register(username, password);
    notifyListeners();
  }

  void logout() {
    _user = null;
    notifyListeners();
  }
}
