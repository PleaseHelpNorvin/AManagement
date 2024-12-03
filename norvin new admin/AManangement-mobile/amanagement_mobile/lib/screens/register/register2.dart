import 'package:amanagement_mobile/api/api.dart';
import 'package:amanagement_mobile/models/profile.dart';
import 'package:amanagement_mobile/utils/https.dart';
import 'package:flutter/foundation.dart' as foundation;
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:http_parser/http_parser.dart';
import 'package:image_picker/image_picker.dart';
import 'dart:io'; // For mobile platform file handling
import 'package:mime/mime.dart';
import 'package:shared_preferences/shared_preferences.dart';
import './contract1.dart';

class Register2 extends StatefulWidget {
  final int userId;
  final String email;
  final String name;
  final String token;

  Register2({
    required this.token, 
    required this.userId, 
    required this.email, 
    required this.name
  });

  @override
  CreateUserProfileScreenState createState() => CreateUserProfileScreenState();
}

class CreateUserProfileScreenState extends State<Register2> {
  final TextEditingController phoneNumberController = TextEditingController();
  final TextEditingController addressController = TextEditingController();
  final TextEditingController emergencyContactController = TextEditingController();
  File? _profilePicture;
  File? _bioPicture;

  Future<void> clearSharedPreferences() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    await prefs.clear();
    print("SharedPreferences cleared.");
    // You can show a confirmation message if needed
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text('SharedPreferences cleared!')),
    );
  }


  // Function to pick a profile picture
  Future<void> _pickProfilePicture() async {
    final picker = ImagePicker();
    final pickedFile = await picker.pickImage(source: ImageSource.gallery);

    if (pickedFile != null) {
      setState(() {
        _profilePicture = File(pickedFile.path);
      });
    }
  }

  // Function to pick a bio picture
  Future<void> _pickBioPicture() async {
    final picker = ImagePicker();
    final pickedFile = await picker.pickImage(source: ImageSource.gallery);

    if (pickedFile != null) {
      setState(() {
        _bioPicture = File(pickedFile.path);
      });
    }
  }

  // Function to handle the profile submission
Future<void> _submitProfile() async {
  if (phoneNumberController.text.trim().isEmpty ||
      addressController.text.trim().isEmpty ||
      emergencyContactController.text.trim().isEmpty) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text('All fields are required.')),
    );
    return;
  }

  try {
    ProfileResponse response = ProfileResponse.fromJson(
      await ApiService().createProfile(
        phoneNumber: phoneNumberController.text.trim(),
        address: addressController.text.trim(),
        emergencyContact: emergencyContactController.text.trim(),
        profilePicture: _profilePicture,
        bio: _bioPicture,
        token: widget.token,
      ),
    );

    if (response.success == true) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Profile created successfully!')),
      );
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => Contract1(
            token: widget.token,
            userId: widget.userId,
            email: widget.email,
            name: widget.name,
          ),
        ),
      );
    } else {
      // Print error message
      String errorMessage = response.message ?? 'Unknown error';
      print('Error: $errorMessage');  // Ensure the error message is printed

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed: $errorMessage')),
      );
    }
  } catch (e) {
    print('An error occurred: $e');  // Log error in the catch block as well
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text('An error occurred. Please try again.')),
    );
  }
}





  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        leading: BackButton(),
        title: Text('Create User Profile'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            Expanded(
              child: SingleChildScrollView(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      'Upload Profile Picture:',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                    ),
                    SizedBox(height: 20),
                    Center(
                      child: GestureDetector(
                        onTap: _pickProfilePicture,
                        child: _profilePicture != null
                            ? CircleAvatar(
                                radius: 60,
                                backgroundImage: FileImage(_profilePicture!),
                              )
                            : const CircleAvatar(
                                radius: 60,
                                child: Icon(Icons.add_a_photo, size: 30),
                              ),
                      ),
                    ),
                    SizedBox(height: 20),
                    TextField(
                      controller: phoneNumberController,
                      decoration: const InputDecoration(
                        labelText: 'Phone Number',
                        border: OutlineInputBorder(),
                        prefixIcon: Icon(Icons.phone),
                      ),
                      keyboardType: TextInputType.phone,
                    ),
                    SizedBox(height: 20),
                    TextField(
                      controller: addressController,
                      decoration: const InputDecoration(
                        labelText: 'Address',
                        border: OutlineInputBorder(),
                        prefixIcon: Icon(Icons.home),
                      ),
                    ),
                    SizedBox(height: 20),
                    TextField(
                      controller: emergencyContactController,
                      decoration: const InputDecoration(
                        labelText: 'Emergency Contact',
                        border: OutlineInputBorder(),
                        prefixIcon: Icon(Icons.contact_phone),
                      ),
                    ),
                    SizedBox(height: 20),
                    Text(
                      'Upload Birth Certificate Picture \n Original or Copy:',
                      style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                    ),
                    SizedBox(height: 10),
                    Center(
                      child: GestureDetector(
                        onTap: _pickBioPicture,
                        child: _bioPicture != null
                            ? Container(
                                height: 100,
                                width: 100,
                                decoration: BoxDecoration(
                                  border: Border.all(color: Colors.grey),
                                  borderRadius: BorderRadius.circular(8),
                                  image: DecorationImage(
                                    image: FileImage(_bioPicture!),
                                    fit: BoxFit.cover,
                                  ),
                                ),
                              )
                            : Container(
                                height: 100,
                                width: 100,
                                decoration: BoxDecoration(
                                  border: Border.all(color: Colors.grey),
                                  borderRadius: BorderRadius.circular(8),
                                ),
                                child: Center(
                                  child: Icon(Icons.add_photo_alternate, size: 30),
                                ),
                              ),
                      ),
                    ),
                    SizedBox(height: 30),
                  ],
                ),
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(20.0),
              child: SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: clearSharedPreferences,  // Call the method here
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size.fromHeight(60),
                    textStyle: const TextStyle(fontSize: 18),
                  ),
                  child: const Text('Clear SharedPreferences'),
                ),
              ),
            ),
            Padding(
              padding: const EdgeInsets.all(20.0),
              child: SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: _submitProfile,
                  style: ElevatedButton.styleFrom(
                    minimumSize: const Size.fromHeight(60),
                    textStyle: const TextStyle(fontSize: 18),
                  ),
                  child: const Text('Register'),
                ),
              ),
            )
          ],
        ),
      ),
    );
  }
}
