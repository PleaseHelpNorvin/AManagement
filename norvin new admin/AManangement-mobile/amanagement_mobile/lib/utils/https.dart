import 'dart:io';

import 'package:amanagement_mobile/models/profile.dart';
import 'package:mime/mime.dart';
import 'dart:convert';
import '../api/api.dart';
import '../models/register.dart';
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

  Future<Map<String, dynamic>> createProfile({
    required String phoneNumber,
    required String address,
    required String emergencyContact,
    File? profilePicture, // Include profile picture as optional
    File? bio, // Include bio as optional
    required String token,
  }) async {
    try {
      var uri = Uri.parse(Api.createProfileEndpoint);

      // Create the MultipartRequest
      var request = http.MultipartRequest('POST', uri)
        ..fields['phone_number'] = phoneNumber
        ..fields['address'] = address
        ..fields['emergency_contact'] = emergencyContact
        ..headers['Authorization'] = 'Bearer $token'; // Add token for authentication

      // Attach profile picture if provided
      if (profilePicture != null) {
        request.files.add(
          await http.MultipartFile.fromPath(
            'profile_picture_url',
            profilePicture.path,
            contentType: MediaType('image', 'jpeg'), // Adjust MIME type as needed
          ),
        );
      }

    // Attach bio if provided
    if (bio != null) {
      request.files.add(
        await http.MultipartFile.fromPath(
          'bio',
          bio.path,
          contentType: MediaType('image', 'jpeg'), // Adjust MIME type as needed
        ),
      );
    }

      // Send the request
      var streamedResponse = await request.send();

      // Parse the response
      var response = await http.Response.fromStream(streamedResponse);

      if (response.statusCode == 200) {
        // Return JSON-decoded response
        return jsonDecode(response.body);
      } else {
        print('Failed to create profile: ${response.body}');
        return {'statusCode': response.statusCode, 'message': response.body};
      }
    } catch (e) {
      print('Error during profile creation: $e');
      return {'statusCode': 500, 'message': 'An error occurred.'};
    }
  }

  
}