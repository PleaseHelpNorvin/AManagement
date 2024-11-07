import 'package:http/http.dart' as http;
import 'dart:convert'; // Import for jsonEncode
import '../pages/clientdatasignup.dart';
import '../api/api.dart';

//models import
import '../model/authmodels/auth_response.dart';
import '../model/authmodels/client_info.dart';
import '../model/authmodels/user_info.dart';


Future<AuthResponse> registerUser(String username, String email, String password) async {
  final response = await http.post(
    Uri.parse(Api.registerEndpoint),
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin' : '*'
    },
    body: jsonEncode({
      'username': username,
      'email': email,
      'password': password,
    }),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    print(" this is register user response: $data");
    return AuthResponse.fromJson(data['data'] );
  } else {
    throw Exception('Failed to register user. Status code: ${response.statusCode}');
  }
}

// Future<AuthResponse> registerUser(String username, String email, String password) async {
//   final response = await http.post(
//     Uri.parse(Api.registerEndpoint),
//     headers: {
//       'Content-Type': 'application/json',
//     },
//     body: jsonEncode({
//       'username': username,
//       'email': email,
//       'password': password,
//     }),
//   );

//   if (response.statusCode == 200) {
//     final data = json.decode(response.body);
//     print("This is register user response: $data");

//     // Convert the userId to an integer before passing it to the API
//     final userId = int.parse(data['data']['user_info']['id'].toString());

//     // Return the AuthResponse while still passing userId as String
//     return AuthResponse.fromJson({
//       'data': {
//         'user_info': {'id': userId.toString()} // Store as String for later use
//       }
//     });
//   } else {
//     throw Exception('Failed to register user. Status code: ${response.statusCode}');
//   }
// }


Future<AuthResponse> loginUser(String username, String password) async {
  final response = await http.post(
    Uri.parse(Api.loginEndpoint),
    headers: {
      'Content-Type': 'application/json',
      'Access-Control-Allow-Origin' : '*'
    },
    
    body: jsonEncode({
      'username': username,
      'password': password,
    }),
  );

  if (response.statusCode == 200) {
    final data = json.decode(response.body);
    return AuthResponse.fromJson(data['data']); // Return parsed AuthResponse directly
  } else {
    final errorMessage = json.decode(response.body)['message'] ?? 'Login failed';
    throw Exception(errorMessage); // Use the error message from the response
  }
}


Future<ClientInfo> updateClientInfo(
    Map<String, dynamic> clientData, String token, int userId) async {
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

      // Check if the 'data' key is present and log the contents
      if (data.containsKey('data')) {
        print('Parsed client data: ${data['data']}');
        return ClientInfo.fromJson(data['data']);
      } else {
        throw Exception('Failed to parse the response, missing "data" field');
      }
    } else {
      throw Exception('Failed to update client info. Status code: ${response.statusCode}');
    }
  } catch (e) {
    print('Error updating client info: $e');
    rethrow;
  }
}



// Future<Map<String, dynamic>> updateClientInfo(Map<String, dynamic> clientData, String token, String userId) async {
//   try {
//     final response = await http.put(
//       Uri.parse('${Api.tenantInfoUpdateEndpoint}/$userId'),
//       headers: {
//         'Content-Type': 'application/json',
//         'Authorization': 'Bearer $token',
//       },
//       body: jsonEncode(clientData),
//     );

//     if (response.statusCode == 200) {
//       final data = json.decode(response.body);
//       return data['data']; // Ensure you're accessing 'data' in response
//     } else {
//       throw Exception('Failed to update client info. Status code: ${response.statusCode}');
//     }
//   } catch (e) {
//     print('Error updating client info: $e');
//     rethrow;
//   }
// }

Future<void> logoutUser(String token, int userId) async {
  final response = await http.post(
    
    Uri.parse(Api.logoutEndpoint),
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer $token',
      'Access-Control-Allow-Origin' : '*'
    },
    
    body: jsonEncode({'user_id': userId}),
  );
print('from logout future $response');
  if (response.statusCode != 200) {
    throw Exception('Failed to log out. Status code: ${response.statusCode}');
  }
}



