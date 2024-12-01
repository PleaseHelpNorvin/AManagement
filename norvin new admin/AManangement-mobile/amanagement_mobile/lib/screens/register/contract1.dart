import 'package:flutter/material.dart';
import 'register2.dart';

class PropertyRoomSelectionScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Select Property and Room")),
      body: Column(
        children: [
          DropdownButtonFormField<String>(
            hint: Text("Select Property"),
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
          Expanded(
            child: ListView.builder(
              itemCount: 5, // Number of rooms
              itemBuilder: (context, index) {
                return ListTile(
                  title: Text("Room $index"),
                  subtitle: Text("Rent: \$1200.00"),
                  trailing: Icon(Icons.chevron_right),
                  onTap: () {
                    // Navigate to the next screen with selected room
                  },
                );
              },
            ),
          ),
          ElevatedButton(
            onPressed: () {
              // Navigate to the next screen
            },
            child: Text("Next"),
          ),
        ],
      ),
    );
  }
}