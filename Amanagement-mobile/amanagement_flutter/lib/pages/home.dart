// import 'package:amanagement_flutter/model/authmodels/client_info.dart';
// import 'package:amanagement_flutter/model/authmodels/user_info.dart';
import '../model/authmodels/user.dart';
import 'package:amanagement_flutter/pages/login.dart';
import 'package:amanagement_flutter/utils/httpmethods.dart';
import 'package:flutter/material.dart';
import 'package:hive/hive.dart';

class Home extends StatefulWidget {
  final int userId;
  final String token;
  final UserInfo userInfo;
  final ClientInfo clientInfo;

  const Home({
    Key? key,
    required this.userId,
    required this.token,
    required this.userInfo,
    required this.clientInfo,
  }) : super(key: key);

  @override
  _HomeState createState() => _HomeState();
}


class _HomeState extends State<Home> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        automaticallyImplyLeading: false,
        title: const Text("Home"),
      ),
      body: Padding(
        padding: const EdgeInsets.all(10.0),
        child: Card(
          elevation: 4,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          child: Padding(
            padding: const EdgeInsets.all(16.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    const Text(
                      "User Information",
                      style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                    ),
                    IconButton(
                      icon: const Icon(Icons.logout, color: Colors.red),
                      onPressed: _logout,
                    ),
                  ],
                ),
                const Divider(),
                Text("Username: ${widget.userInfo.username}", style: const TextStyle(fontSize: 18)),
                Text("Email: ${widget.userInfo.email}", style: const TextStyle(fontSize: 18)),
                const SizedBox(height: 20),
                Text("Name: ${widget.clientInfo.name} ${widget.clientInfo.middlename} ${widget.clientInfo.lastname}", style: const TextStyle(fontSize: 18)),
                Text("Gender: ${widget.clientInfo.gender}", style: const TextStyle(fontSize: 18)),
                Text("Address: ${widget.clientInfo.address}", style: const TextStyle(fontSize: 18)),
                Text("Contact Number: ${widget.clientInfo.contactNumber}", style: const TextStyle(fontSize: 18)),
                const SizedBox(height: 20),
                Text("Token: ${widget.token}", style: const TextStyle(fontSize: 16)),
                Text("User ID: ${widget.userId}", style: const TextStyle(fontSize: 16)),
                Text("IsLoggedIn: ${widget.userInfo.isLoggedIn}", style: const TextStyle(fontSize: 16)),
              ],
            ),
          ),
        ),
      ),
    );
  }


  void _showErrorDialog(String message) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: const Text('Error'),
          content: Text(message),
          actions: <Widget>[
            TextButton(
              onPressed: () {
                Navigator.of(context).pop(); // Close the dialog
              },
              child: const Text('OK'),
            ),
          ],
        );
      },
    );
  }

  // Function to log out the user and clear the Hive storage
  // void _logout() async {
  //   try {
  //     await logoutUser(token, widget.userId);

  //     final box = await Hive.openBox('accounts');
  //     await box.delete('token');
  //     await box.delete('userId');

  //     // After successful logout, navigate to the login screen
  //     Navigator.pushReplacement(
  //       context,
  //       MaterialPageRoute(builder: (context) => const Login()),
  //     );
  //   } catch (e) {
  //     // Handle any errors (e.g., failed logout)
  //     print("Error: $e");
  //     _showErrorDialog("Failed to log out. Please try again.");
  //   }
  // }
  void _logout() async {
    try {
      await logoutUser(widget.token, widget.userId);

      final box = await Hive.openBox('accounts');
      await box.delete('token');
      await box.delete('userId');

      // After successful logout, navigate to the login screen
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (context) => const Login()),
      );
    } catch (e) {
      // Handle any errors (e.g., failed logout)
      print("Error: $e");
      _showErrorDialog("Failed to log out. Please try again.");
    }
  }
}
