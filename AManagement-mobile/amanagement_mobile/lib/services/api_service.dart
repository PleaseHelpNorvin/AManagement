import 'dart:convert';
import 'package:http/http.dart' as http;
import '../config/api.dart';
import '../models//user.dart';

class ApiService {
  // Future<User?> login(String username, String password) async {
  //   final response = await http.post(
  //     Uri.parse(Api.loginEndpoint),
  //     headers: {'Content-Type': 'application/json'},
  //     body: jsonEncode({
  //       'username': username, 
  //       'password': password,
  //     }),
  //   );

  //   if (response.statusCode == 200) {
  //     return User.fromJson(json.decode(response.body));
  //   } else {
  //     throw Exception('Failed to login: ${response.body}');
  //   }
  // } 

  // Future<User?> registerUser(String name, String email, String password) async {
  //   final response = await http.post(
  //     Uri.parse(Api.registerEndpoint),
  //     headers: {'Content-Type': 'application/json'},
  //     body: json.encode({
  //       'name': name,
  //       'email': email,
  //       'password': password,
  //       'role': 0, // Static role set to 0
  //     }),
  //   );

  //   if (response.statusCode == 201) {
  //     final data = json.decode(response.body);
  //     return User.fromJson(data); // Assuming the response includes user data
  //   } else {
  //     throw Exception('Failed to register user: ${response.body}');
  //   }
  // }
}
