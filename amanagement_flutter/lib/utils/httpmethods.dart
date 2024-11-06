import 'package:http/http.dart' as http;
import 'dart:convert'; // Import for jsonEncode
import '../pages/clientdatasignup.dart';
import '../api/api.dart';


Future<http.Response> registerUser(String username, String email, String password) async {
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
  return response;
}


Future<http.Response> loginUser(String username, String password) async {
  return await http.post(
    Uri.parse(Api.loginEndpoint),
    headers: {
      'Content-Type': 'application/json', // Set content type for JSON
    },
    body: jsonEncode({ // Convert body to JSON
      'username': username,
      'password': password,
    }),
  );
}



Future<Map<String, dynamic>> updateClientInfo(Map<String, dynamic> clientData, String token, String userId) async {
  try {
    final response = await http.put(
      Uri.parse('${Api.tenantInfoUpdateEndpoint}/$userId'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: jsonEncode(clientData),
    );

    // Check for a successful response (200)
    if (response.statusCode == 200) {
      final data = json.decode(response.body);
      return data;  // Return the response data
    } else {
      throw Exception('Failed to update client info. Status code: ${response.statusCode}');
    }
  } catch (e) {
    print('Error updating client info: $e');
    rethrow;  // Rethrow the error to be handled by the calling code
  }
}


// }
// Future<http.Response> updateClientInfo(Map<String, dynamic> clientData, String token, String userId) async {
//   // final url = ';  // Replace with actual URL
//   final headers = {
//     'Authorization': 'Bearer $token',
//     'Content-Type': 'application/json',
//   };
//   final body = json.encode(clientData);

//   return await http.post(
//     Uri.parse(Api.tenantInfoUpdateEndpoint),
//     headers: headers,
//     body: body,
//   );
// }


// Future<http.Response> logoutUser(String token,String userId) async {
//   return await http.post(
//     Uri.parse(Api.logoutEndpoint), // Use the logout endpoint from your API class
//     headers: {
//       'Content-Type': 'application/json', // Set content type for JSON
//       'Authorization': 'Bearer $token', // Include the token in the Authorization header
//     },
//     body: jsonEncode({'user_id': userId})
  
//   );
// }
Future<http.Response> logoutUser(String token, String userId) async {
  return await http.post(
    Uri.parse(Api.logoutEndpoint), // Use the logout endpoint from your API class
    headers: {
      'Content-Type': 'application/json', // Set content type for JSON
      'Authorization': 'Bearer $token', // Include the token in the Authorization header
    },
    body: jsonEncode({
      'user_id': userId,
    }),
  );
}


