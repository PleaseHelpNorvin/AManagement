// import 'package:amanagement_flutter/model/authmodels/update_client_response.dart';
import 'package:amanagement_flutter/pages/login.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:convert'; // Import for jsonEncode
import '../pages/clientdatasignup.dart';
import '../api/api.dart';

//models import
import '../model/authmodels/user.dart';

// Future<void> _saveUserInfo(String token) async {
//   final prefs = await SharedPreferences.getInstance();
//   prefs.setString('authToken', token);  // Save the token to SharedPreferences
//   prefs.setBool('isLoggedIn', true);    // Set the user as logged in
// }

Future<RegisterResponse?> registerUser(
  String username,
  String email,
  String password,
) async {
  try {
    final response = await http.post(
      Uri.parse(Api.registerEndpoint),
      headers: {
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'username': username,
        'email': email,
        'password': password,
      }),
    );

    if (response.statusCode == 200) {
      // If the server returns a 200 OK response, parse the JSON
      final Map<String, dynamic> responseBody = jsonDecode(response.body);

      // Return the parsed response as a RegisterResponse object
      return RegisterResponse.fromJson(responseBody);
    } else {
      // Handle non-200 responses
      print('Failed to register: ${response.body}');
      return null;
    }
  } catch (e) {
    print('Error during registration: $e');
    return null;
  }
}

Future<RegisterResponse> updateClientInfo(
  Map<String, dynamic> clientData,
  String token,
  int userId,
) async {
  try {
    final response = await http.post(
      Uri.parse('${Api.tenantInfoUpdateEndpoint}/$userId'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
        'Access-Control-Allow-Origin': '*',
      },
      body: jsonEncode(clientData),
    );

    // Log the response status and body for debugging
    print('Response Status Code: ${response.statusCode}');
    print('Response Body: ${response.body}');

    if (response.statusCode == 200) {
      final data = json.decode(response.body);

      // Assuming the response structure matches what RegisterResponse expects
      return RegisterResponse.fromJson(data);
    } else {
      throw Exception(
          'Failed to update client info. Status code: ${response.statusCode}');
    }
  } catch (e) {
    print('Error updating client info: $e');
    rethrow; // Propagate the error
  }
}

Future<LoginResponse?> loginUser( 
  String username,
  String password,
) async {
  try {
    final response = await http.post(
      Uri.parse(Api.loginEndpoint),
      headers: {
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'username': username,
        'password': password
      }),
    );
    if(response.statusCode == 200) {
      final Map<String, dynamic> responseBody = jsonDecode(response.body);
      return LoginResponse.fromJson(responseBody);
    }else{
      print('Failed to login ${response.body}');
      return null;
    }
  } catch (e) {
    print('Error during registration: $e');
    return null;
  }
}

// Future<LoginResponse?> loginUser(String username, String password) async {
//   try {
//     final response = await http.post(
//       Uri.parse(Api.loginEndpoint),
//       headers: {
//         'Content-Type': 'application/json',
//       },
//       body: jsonEncode({
//         'username': username,
//         'password': password
//       }),
//     );

//     if (response.statusCode == 200) {
//       final Map<String, dynamic> responseBody = jsonDecode(response.body);
//       return LoginResponse.fromJson(responseBody);
//     } else {
//       print('Failed to login: ${response.body}');
//       return null;
//     }
//   } catch (e) {
//     print('Error during login: $e');
//     return null;
//   }
// }



Future<void> logoutUser(String token, int userId) async {
  final response = await http.post(
    Uri.parse(Api.logoutEndpoint),
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer $token',
      'Access-Control-Allow-Origin': '*'
    },
    body: jsonEncode({'user_id': userId}),
  );
  print('from logout future $response');
  if (response.statusCode != 200) {
    print('Logout failed with response: ${response.body}');
    throw Exception('Failed to log out. Status code: ${response.statusCode}');
  }
}

