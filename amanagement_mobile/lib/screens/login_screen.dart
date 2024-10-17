import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../providers/auth_provider.dart';
import '../widgets/custom_button.dart';
import '../widgets/text_field.dart';
import '../utils/helpers.dart';

class LoginScreen extends StatelessWidget {
  final TextEditingController usernameController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  LoginScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('')),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Consumer<AuthProvider>(
          builder: (  context, authProvider, child) => Column(
              children: [
                CustomTextField(
                  label: 'Username',
                  controller: usernameController,
                ),
                CustomTextField(
                  label: 'Password',
                  controller: passwordController,
                  obscureText: true,
                ),
                const SizedBox(height: 20),
                CustomButton(
                  label: 'Login',
                  onPressed: () async {
                    try {
                      await authProvider.login(usernameController.text, passwordController.text);
                      // Navigate to the dashboard
                    } catch (e) {
                      // ignore: use_build_context_synchronously
                      Helpers.showSnackbar(context, 'Login failed: $e');
                    }
                  },
                ),
              ],
            ),
        ),
      ),
    );
  }
}
