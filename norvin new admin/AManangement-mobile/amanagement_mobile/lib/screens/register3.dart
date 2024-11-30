import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'dart:io';

class Register3 extends StatefulWidget {
  final String email;
  final String password;

  Register3({required this.email, required this.password});

  @override
  _CreateUserProfileScreenState createState() =>
      _CreateUserProfileScreenState();
}

class _CreateUserProfileScreenState extends State<Register3> {
  final TextEditingController phoneNumberController = TextEditingController();
  final TextEditingController addressController = TextEditingController();
  final TextEditingController emergencyContactController =
      TextEditingController();
  File? _profilePicture;
  File? _bioPicture;

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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Create User Profile'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: SingleChildScrollView(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Phone Number Field
              TextField(
                controller: phoneNumberController,
                decoration: InputDecoration(
                  labelText: 'Phone Number',
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.phone),
                ),
                keyboardType: TextInputType.phone,
              ),
              SizedBox(height: 20),
              // Address Field
              TextField(
                controller: addressController,
                decoration: InputDecoration(
                  labelText: 'Address',
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.home),
                ),
              ),
              SizedBox(height: 20),
              // Emergency Contact Field
              TextField(
                controller: emergencyContactController,
                decoration: InputDecoration(
                  labelText: 'Emergency Contact',
                  border: OutlineInputBorder(),
                  prefixIcon: Icon(Icons.contact_phone),
                ),
              ),
              SizedBox(height: 20),
              // Profile Picture Upload
              Text(
                'Upload Profile Picture:',
                style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
              ),
              SizedBox(height: 10),
              Center(
                child: GestureDetector(
                  onTap: _pickProfilePicture,
                  child: _profilePicture != null
                      ? CircleAvatar(
                          radius: 50,
                          backgroundImage: FileImage(_profilePicture!),
                        )
                      : CircleAvatar(
                          radius: 50,
                          child: Icon(Icons.add_a_photo, size: 30),
                        ),
                ),
              ),
              SizedBox(height: 20),
              // Bio Picture Upload
              Text(
                'Upload Bio Picture:',
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
              // Save Button
              Center(
                child: ElevatedButton(
                  onPressed: () {
                    // Save profile details or make an API call here
                    print('Email: ${widget.email}');
                    print('Password: ${widget.password}');
                    print('Phone: ${phoneNumberController.text}');
                    print('Address: ${addressController.text}');
                    print('Emergency Contact: ${emergencyContactController.text}');
                    print('Profile Picture Path: ${_profilePicture?.path}');
                    print('Bio Picture Path: ${_bioPicture?.path}');
                    ScaffoldMessenger.of(context).showSnackBar(
                      SnackBar(content: Text('User Profile Created!')),
                    );
                  },
                  child: Text('Create Profile'),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
