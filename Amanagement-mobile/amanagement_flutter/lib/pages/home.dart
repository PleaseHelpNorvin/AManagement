import 'package:amanagement_flutter/model/authmodels/user.dart';
import 'package:amanagement_flutter/pages/login.dart';
import 'package:amanagement_flutter/pages/adminmessage.dart';
import 'package:amanagement_flutter/pages/paydue.dart';
import 'package:amanagement_flutter/pages/secondpage.dart';

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
  int currentPageIndex = 0; // Track selected page

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
      automaticallyImplyLeading: false,
      title: const Text("Home"),
      elevation: 5.0,  // Sets the height of the shadow
      shadowColor: Colors.black.withOpacity(0.4), // Set the color of the shadow
      actions: [
        IconButton(
          icon: const Icon(Icons.logout, color: Colors.red),
          onPressed: _logout,
        ),
      ],
    ),
      bottomNavigationBar: NavigationBar(
        onDestinationSelected: (int index) {
          setState(() {
            currentPageIndex = index;
          });
        },
        indicatorColor: Colors.amber,
        selectedIndex: currentPageIndex,
        destinations: const <Widget>[
          NavigationDestination(
            selectedIcon: Icon(Icons.home),
            icon: Icon(Icons.home_outlined),
            label: 'Home',
          ),
          NavigationDestination(
            icon: Badge(child: Icon(Icons.notifications_sharp)),
            label: 'Notifications',
          ),
          NavigationDestination(
            icon: Badge(
              label: Text('2'),
              child: Icon(Icons.messenger_sharp),
            ),
            label: 'Messages',
          ),
        ],
      ),
      body: <Widget>[
        // Home Page Content
        Padding(
          padding: const EdgeInsets.all(10.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildUserInfoCard(),
              const SizedBox(height: 20),
              _buildSmallerCards(),
            ],
          ),
        ),
        // Notifications Page Content
        const Padding(
          padding: EdgeInsets.all(8.0),
          child: Column(
            children: <Widget>[
              Card(
                child: ListTile(
                  leading: Icon(Icons.notifications_sharp),
                  title: Text('Notification 1'),
                  subtitle: Text('This is a notification'),
                ),
              ),
              Card(
                child: ListTile(
                  leading: Icon(Icons.notifications_sharp),
                  title: Text('Notification 2'),
                  subtitle: Text('This is a notification'),
                ),
              ),
            ],
          ),
        ),
        // Messages Page Content
        ListView.builder(
          reverse: true,
          itemCount: 2,
          itemBuilder: (BuildContext context, int index) {
            return _buildMessage(index);
          },
        ),
      ][currentPageIndex], // Display content based on selected tab
    );
  }

  Widget _buildUserInfoCard() {
    return Card(
      elevation: 4,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              "User Information",
              style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
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
    );
  }

  // Widget _buildSmallerCards() {
  //   return Row(
  //     mainAxisAlignment: MainAxisAlignment.spaceBetween,
  //     children: [
  //       _buildCard(
  //         "Pay due", 
  //         "Content for the first card",
  //         () {
  //           Navigator.push
  //         } 
          
  //         ),
  //       _buildCard("Card 2", "Content for the second card"),
  //     ],
  //   );
  // }
  Widget _buildSmallerCards() {
  return Row(
    mainAxisAlignment: MainAxisAlignment.spaceBetween,
    children: [
      _buildCard(
        "Pay due",
        "Content for the first card",
        PayDuePage(), // Directly pass the widget class
      ),
      _buildCard(
        "Card 2",
        "Content for the second card",
        SecondPage(), // Directly pass the widget class
      ),
    ],
  );
}

Widget _buildCard(String title, String content, Widget page) {
  return Container(
    width: (MediaQuery.of(context).size.width - 40) / 2, // Half the width of the screen minus padding
    height: 200, 
    child: Card(
      elevation: 4,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Padding(
        padding: const EdgeInsets.all(10.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(title, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
            const Divider(),
            Text(content, style: const TextStyle(fontSize: 16)),
            const Spacer(), // Add spacer to push the button to the bottom
            TextButton(
              onPressed: () {
                // Directly push the page class (no need for route name)
                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => page),
                );
              },
              child: const Text('Go to Page', style: TextStyle(fontSize: 16)),
              style: TextButton.styleFrom(
                foregroundColor: Colors.white, backgroundColor: Colors.blue, // Button background color
              ),
            ),
          ],
        ),
      ),
    ),
  );
}



//   Widget _buildCard(String title, String content, VoidCallback onPressed) {
//   return Container(
//     width: (MediaQuery.of(context).size.width - 40) / 2, // Half the width of the screen minus padding
//     height: 200, 
//     child: Card(
//       elevation: 4,
//       shape: RoundedRectangleBorder(
//         borderRadius: BorderRadius.circular(12),
//       ),
//       child: Padding(
//         padding: const EdgeInsets.all(10.0),
//         child: Column(
//           crossAxisAlignment: CrossAxisAlignment.start,
//           children: [
//             Text(title, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
//             const Divider(),
//             Text(content, style: const TextStyle(fontSize: 16)),
//             const Spacer(), // Add spacer to push the button to the bottom
//             TextButton(
//               onPressed: onPressed, // Action for button press
//               child: const Text('Go to Page', style: TextStyle(fontSize: 16)),
//               style: TextButton.styleFrom(
//                 foregroundColor: Colors.white, backgroundColor: Colors.blue, // Button background color
//               ),
//             ),
//           ],
//         ),
//       ),
//     ),
//   );
// }


  Widget _buildMessage(int index) {
    return Align(
      alignment: index == 0 ? Alignment.centerRight : Alignment.centerLeft,
      child: Container(
        margin: const EdgeInsets.all(8.0),
        padding: const EdgeInsets.all(8.0),
        decoration: BoxDecoration(
          color: Theme.of(context).colorScheme.primary,
          borderRadius: BorderRadius.circular(8.0),
        ),
        child: Text(
          index == 0 ? 'Hello' : 'Hi!',
          style: Theme.of(context).textTheme.bodyLarge!.copyWith(color: Theme.of(context).colorScheme.onPrimary),
        ),
      ),
    );
  }

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
      print("Error: $e");
      _showErrorDialog("Failed to log out. Please try again.");
    }
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
}
