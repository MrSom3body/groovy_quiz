# 🧠 MrSom3body's Quiz

A lightweight quiz application built in PHP, powered by XML and DTD validation.  
No database needed. Just categories, questions, and colorful styles — straight from structured XML.

## ✨ Features

- 📂 **Category-based Navigation**  
  Choose your category → subcategory → start answering!
- 📝 **XML-driven Questions**  
  All quiz content is defined in a simple `quiz.xml`, validated with DTD.
- 🎨 **Dynamic Styling**  
  Colors and layout adapt based on the number of options.
- 📊 **Score Breakdown**  
  See your performance with color-coded feedback at the end.

## 🚀 Getting Started
1. Clone the repo:
  ```bash
  git clone https://github.com/MrSom3body/groovy_quiz.git
  cd groovy_quiz
  ```
2. Place your `quiz.xml` in the root or use the provided sample.
3. Make sure `quiz.dtd` is in the same directory — it’s required for validation.
4. Serve the app:
  ```bash
  podman compose up
  ```
4. Open http://localhost:8888 and enjoy 🎉

## 🛠  Dependencies
- podman
