class Validators {
  static String? validateEmail (String? value) {
    if(value == null || value.isEmpty) {
      return 'please enter your email';
    }
    final RegExp emailRegex = RegExp(r'^[^@]+@[^@]+\.[^@]+');
    if(!emailRegex.hasMatch(value)) {
      return 'please enter a valid email';
    }
    return null;
  }

  static String? validatePassword(String? value) {
    if(value == null || value.length < 6) {
      return 'password must be at least 6 characters';
    }
    return null;
  }
}