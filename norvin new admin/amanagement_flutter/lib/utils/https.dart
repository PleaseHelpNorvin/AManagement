import 'dart:io';

import '../model/login.dart';
import '../model/profile.dart';
import 'package:mime/mime.dart';
import 'dart:convert';
import '../api/api.dart';
import '../model/register.dart';
import '../model/room.dart';
import 'package:http/http.dart' as http;
import 'package:path/path.dart';  // To use basename
import 'package:http_parser/http_parser.dart';  // To use MediaType



class ApiService {
  //register User
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
          'name': username,
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

  Future<LoginResponse?>loginUser(String email, String password) async { 
    try {
      final response = await http.post(
        Uri.parse(Api.loginEndpoint),
        headers: {
          'Content-Type': 'application/json',
        },
        body: jsonEncode({
            'email': email,
            'password':password,
          }),
      );

      if(response.statusCode == 200) {
        final Map<String, dynamic> responseBody = jsonDecode(response.body);
        print(responseBody);
        return LoginResponse.fromJson(responseBody);
      } else {
        print('Failed to register: ${response.body}');
        return null;
      }
    } catch (e) {
      print('Error during registration: $e');
      return null;
    }
  }

   Future<bool> logoutUser(String token) async {
    final url = Uri.parse(Api.logoutEndpoint);

    try {
      final response = await http.post(
        url,
        headers: {
          'Authorization': 'Bearer $token', // Pass the token for authentication
          'Accept': 'application/json', // Expected response format
        },
      );

      if (response.statusCode == 200) {
        // Successfully logged out
        return true;
      } else {
        // Handle failed logout
        print('Logout failed: ${response.body}');
        return false;
      }
    } catch (e) {
      print('Error logging out: $e');
      return false;
    }
  }

Future<Map<String, dynamic>> createProfile({
  required String phoneNumber,
  required String address,
  required String emergencyContact,
  File? profilePicture, // Optional profile picture
  File? bio, // Optional bio file
  required String token,
}) async {
  try {
    var uri = Uri.parse(Api.createProfileEndpoint);

    // Create the MultipartRequest
    var request = http.MultipartRequest('POST', uri)
      ..fields['phone_number'] = phoneNumber
      ..fields['address'] = address
      ..fields['emergency_contact'] = emergencyContact
      ..headers['Authorization'] = 'Bearer $token';

    // Attach profile picture if provided
    if (profilePicture != null) {
      request.files.add(
        await http.MultipartFile.fromPath(
          'profile_picture_url',
          profilePicture.path,
          contentType: MediaType('image', 'jpeg'), // Adjust MIME type for image
        ),
      );
    }

    // Attach bio if provided
    if (bio != null) {
      request.files.add(
        await http.MultipartFile.fromPath(
          'bio',
          bio.path,
          contentType: MediaType('image', 'jpeg'), // Adjust MIME type based on bio file format
        ),
      );
    }

      // Send the request and handle response
      var streamedResponse = await request.send();
      var response = await http.Response.fromStream(streamedResponse);

      // Log for debugging
      print('Response Status Code: ${response.statusCode}');
      print('Response Body: ${response.body}');

      // Decode the response body
      var responseData = jsonDecode(response.body);
      print('createProfile responseData: $responseData');
      if (responseData['success'] == true) { 
        return responseData; // Return the created profile data
        
      } else {
        print('Failed to create profile: ${response.body}');
        return {'statusCode': response.statusCode, 'message': response.body};
      }
    } catch (e) {
      print('Error during profile creation: $e');
      return {'statusCode': 500, 'message': 'An error occurred during the request.'};
    }
  }

  Future<List<Property>> fetchProperties(String token) async {
    final response = await http.get(
      Uri.parse(Api.getPropertiesEndpoint),
      headers: {
        'Authorization': 'Bearer $token',
        'Content-Type': 'application/json',
      },
    );

    if (response.statusCode == 200) {
      List jsonResponse = json.decode(response.body)['data'];
      return jsonResponse.map((property) => Property.fromJson(property)).toList();
    } else {
      throw Exception('Failed to load properties');
    }
  }
   // Fetch Rooms based on Property ID
  Future<List<Room>> fetchRoomsByProperty(int propertyId, String token) async {
    final response = await http.get(
      Uri.parse('${Api.getRoomsEndpoint}/${propertyId}'),
      headers: {'Authorization': 'Bearer $token'},
    );

    if (response.statusCode == 200) {
      List jsonResponse = json.decode(response.body)['data'];
      return jsonResponse.map((room) => Room.fromJson(room)).toList();
    } else {
      throw Exception('Failed to load rooms');
    }
  }

  
  
}