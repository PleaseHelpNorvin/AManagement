import 'package:flutter/material.dart';

class CustomButton extends StatelessWidget {
  final VoidCallback  onPressed;
  final String label;
  final Color color;
  final Color textColor;
  
  const CustomButton({
    super.key,
    required this.label,
    required this.onPressed,
    this.color = Colors.blue,
    this.textColor = Colors.white,
  });

  @override
  Widget build(BuildContext context) {
    return ElevatedButton(
      onPressed: onPressed, 
      style: ElevatedButton.styleFrom(backgroundColor: color),
      child: Text(
        label,
        style: TextStyle(
          color: textColor
        ),
      ),
    );
  }
}