import 'package:flutter/material.dart';
import 'register2.dart';

class PropertyRoomSelectionScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Select Property and Room")),
      body: Padding(
        padding: const EdgeInsets.all(16.0), // Apply padding to the entire body
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start, // Align text to the left
          children: [
            Text(
              "Please select a property from the list below:",
              style: TextStyle(fontSize: 16.0, fontWeight: FontWeight.w600),
            ),
            SizedBox(height: 8.0), // Add spacing between the text and dropdown
            DropdownButtonFormField<String>(
              hint: Text("Where are you now?"),
              items: ["Property 1", "Property 2"].map((property) {
                return DropdownMenuItem(
                  value: property,
                  child: Text(property),
                );
              }).toList(),
              onChanged: (value) {
                // Update room list based on property selection
              },
            ),
            SizedBox(height: 16.0), // Add spacing between dropdown and list
            Expanded(
              child: ListView.builder(
                itemCount: 5, // Number of rooms
                itemBuilder: (context, index) {
                  return Padding(
                    padding: const EdgeInsets.symmetric(vertical: 4.0),
                    child: ListTile(
                      title: Text("Room $index"),
                      subtitle: Text("Rent: \$1200.00"),
                      trailing: Icon(Icons.chevron_right),
                      onTap: () {
                        // Navigate to the next screen with selected room
                      },
                    ),
                  );
                },
              ),
            ),
            SizedBox(height: 16.0), // Add spacing above the button
            ElevatedButton(
              onPressed: () {
                // Navigate to the next screen
              },
              child: Center(child: Text("Next")),
            ),
          ],
        ),
      ),
    );
  }
}
