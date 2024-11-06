import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';

import 'package:amanagement_flutter/main_app.dart'; // Make sure to import MainApp instead of main.dart

void main() {
  testWidgets('Counter increments smoke test', (WidgetTester tester) async {
    // Build our app and trigger a frame.
    await tester.pumpWidget(const MainApp()); // Use MainApp here

    // Verify that the initial screen displays the expected text.
    expect(find.text('Welcome'), findsOneWidget); // Update this based on your Login widget's initial state

    // If you have a counter or a similar widget, replace the following code accordingly.
    // For example, if there's a button that increments a counter in your home page, do the following:
    // await tester.tap(find.byIcon(Icons.add)); // Update based on your actual widget structure
    // await tester.pump();

    // Verify that the counter has incremented (or check for expected changes).
    // expect(find.text('1'), findsOneWidget); // Replace as necessary
  });
}
