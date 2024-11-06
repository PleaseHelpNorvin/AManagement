import 'dart:convert';
import 'package:amanagement_flutter/pages/login.dart';
import 'package:amanagement_flutter/utils/httpmethods.dart';
import 'package:flutter/material.dart';
import 'package:hive/hive.dart';

class Home extends StatefulWidget {
  final String clientData;
  final String username;

  // Constructor to accept clientData
  Home({
    required this.clientData,
    required this.username,
  });

  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  late Map<String, dynamic> decodedData;
  late String userId;
  late String token;

  // @override
  // void initState() {
  //   super.initState();
  //   print("Raw clientData: ${widget.clientData}");

  //   // Decode client data here
  //   try {
  //     decodedData = json.decode(widget.clientData);
  //     print("Decoded clientData: $decodedData");

  //     userId = decodedData['user_id']?.toString() ?? '';
  //     token = decodedData['token']?.toString() ?? '';

  //     print("User ID: $userId, Token: $token");

  //     if (userId.isEmpty || token.isEmpty) {
  //       throw Exception('Missing user data or token.');
  //     }
  //   } catch (e) {
  //     print("Error decoding clientData: $e");
  //     decodedData = {};
  //   }
  // }
  @override
void initState() {
  super.initState();
  print("Raw clientData: ${widget.clientData}");

  // Decode client data here
  try {
    decodedData = json.decode(widget.clientData);
    print("Decoded clientData: $decodedData");

    // Debugging each expected field
    print("Name: ${decodedData['client_info']?['name'] ?? 'N/A'}");
    print("Middlename: ${decodedData['client_info']?['middlename'] ?? 'N/A'}");
    print("Lastname: ${decodedData['client_info']?['lastname'] ?? 'N/A'}");
    print("Gender: ${decodedData['client_info']?['gender'] ?? 'N/A'}");
    print("Address: ${decodedData['client_info']?['address'] ?? 'N/A'}");
    print("Contact Number: ${decodedData['client_info']?['contact_number'] ?? 'N/A'}");


    userId = decodedData['user_id']?.toString() ?? '';
    token = decodedData['token']?.toString() ?? '';
    print("User ID: $userId, Token: $token");

    if (userId.isEmpty || token.isEmpty) {
      throw Exception('Missing user data or token.');
    }
  } catch (e) {
    print("Error decoding clientData: $e");
    decodedData = {};
  }
}


  @override
  Widget build(BuildContext context) {
    // If decodedData is empty or missing, show an error message
    if (decodedData.isEmpty) {
      return Scaffold(
        appBar: AppBar(title: Text("Error")),
        body: Center(child: Text('Invalid data received!')),
      );
    }

    return Scaffold(
      appBar: AppBar(
        title: Text("Home"),
        actions: [
          IconButton(
            icon: Icon(Icons.logout),
            onPressed: _logout,
          ),
        ],
      ),
      body: Padding(
        padding: EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            //  Text("Username: ${decodedData['username'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            // Text("Name: ${decodedData['client_info']['name'] ?? 'N/A'} ${decodedData['client_info']['middlename'] ?? ''} ${decodedData['client_info']['lastname'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            // Text("Gender: ${decodedData['client_info']['gender'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            // Text("Address: ${decodedData['client_info']['address'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            // Text("Contact Number: ${decodedData['client_info']['contact_number'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            // SizedBox(height: 20),
            // Text("Token: ${decodedData['token'] ?? 'N/A'}", style: TextStyle(fontSize: 16)),
            // Text("User ID: ${decodedData['user_id'] ?? 'N/A'}", style: TextStyle(fontSize: 16)),

            Text("Username: ${decodedData['username'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            Text("Name: ${decodedData['name'] ?? 'N/A'} ${decodedData['middlename'] ?? ''} ${decodedData['lastname'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            Text("Gender: ${decodedData['gender'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            Text("Address: ${decodedData['address'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            Text("Contact Number: ${decodedData['contact_number'] ?? 'N/A'}", style: TextStyle(fontSize: 18)),
            SizedBox(height: 20),
            Text("Token: ${decodedData['token'] ?? 'N/A'}", style: TextStyle(fontSize: 16)),
            Text("User ID: ${decodedData['user_id'] ?? 'N/A'}", style: TextStyle(fontSize: 16)),
          ],
        ),
      ),
    );
  }

  // Function to log out the user and clear the Hive storage
  void _logout() async {
    // Send a logout request with the user_id and token
    var response = await logoutUser(token, userId);
    final box = await Hive.openBox('accounts');
    await box.delete('token');
    await box.delete('userId');

    // Handle response
    if (response.statusCode == 200) {
      print("Logout successful");
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => const Login()),
      ); // Navigate to login page
    } else {
      print("Logout failed: ${response.body}");
    }
  }
}
