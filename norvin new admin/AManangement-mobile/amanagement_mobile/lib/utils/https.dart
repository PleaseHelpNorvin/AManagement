import '../api/api.dart';

// Future<RegisterResponse?> registerUser(
//   String username,
//   String email,
//   String password,
// ) async {
//   try {
//     final response = await http.post(
//       Uri.parse(Api.registerEndpoint),
//       headers: {
//         'Content-Type': 'application/json',
//       },
//       body: jsonEncode({
//         'username': username,
//         'email': email,
//         'password': password,
//       }),
//     );

//     if (response.statusCode == 200) {
//       // If the server returns a 200 OK response, parse the JSON
//       final Map<String, dynamic> responseBody = jsonDecode(response.body);

//       // Return the parsed response as a RegisterResponse object
//       return RegisterResponse.fromJson(responseBody);
//     } else {
//       // Handle non-200 responses
//       print('Failed to register: ${response.body}');
//       return null;
//     }
//   } catch (e) {
//     print('Error during registration: $e');
//     return null;
//   }
// }