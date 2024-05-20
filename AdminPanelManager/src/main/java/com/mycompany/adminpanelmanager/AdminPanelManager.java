package com.mycompany.adminpanelmanager;

import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
import java.sql.*;

public class AdminPanelManager extends JFrame implements ActionListener {
    // Declare buttons for various admin actions
    private JButton addVideoButton, updateVideoButton, deleteVideoButton,
                    addMovieButton, updateMovieButton, deleteMovieButton,
                    addTVSeriesButton, updateTVSeriesButton, deleteTVSeriesButton;
    // Declare database connection object
    private Connection conn;

    // Constructor
    public AdminPanelManager() {
        super("Admin Panel Manager"); // Set the title of the window
        initializeGUI(); // Initialize the graphical user interface
        connectToDatabase(); // Establish a connection to the database
    }

    // Method to initialize the GUI
    private void initializeGUI() {
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE); // Set the default close operation
        setLayout(new GridLayout(3, 3)); // Set the layout of the frame to a 3x3 grid

        // Initialize buttons with their respective labels
        addVideoButton = new JButton("Add Video");
        updateVideoButton = new JButton("Update Video");
        deleteVideoButton = new JButton("Delete Video");
        addMovieButton = new JButton("Add Movie");
        updateMovieButton = new JButton("Update Movie");
        deleteMovieButton = new JButton("Delete Movie");
        addTVSeriesButton = new JButton("Add TV Series");
        updateTVSeriesButton = new JButton("Update TV Series");
        deleteTVSeriesButton = new JButton("Delete TV Series");

        // Register action listeners for each button
        addVideoButton.addActionListener(this);
        updateVideoButton.addActionListener(this);
        deleteVideoButton.addActionListener(this);
        addMovieButton.addActionListener(this);
        updateMovieButton.addActionListener(this);
        deleteMovieButton.addActionListener(this);
        addTVSeriesButton.addActionListener(this);
        updateTVSeriesButton.addActionListener(this);
        deleteTVSeriesButton.addActionListener(this);

        // Add buttons to the frame
        add(addVideoButton);
        add(updateVideoButton);
        add(deleteVideoButton);
        add(addMovieButton);
        add(updateMovieButton);
        add(deleteMovieButton);
        add(addTVSeriesButton);
        add(updateTVSeriesButton);
        add(deleteTVSeriesButton);

        pack(); // Pack the components within the window
        setLocationRelativeTo(null); // Center the window on the screen
        setVisible(true); // Make the window visible
    }

    // Method to establish a connection to the database
    private void connectToDatabase() {
        try {
            // Database connection parameters
            String url = "jdbc:mysql://localhost:3306/videos4free";
            String username = "root";
            String password = "";

            conn = DriverManager.getConnection(url, username, password); // Establish the connection
        } catch (SQLException e) {
            e.printStackTrace(); // Print the stack trace for debugging
            JOptionPane.showMessageDialog(null, "Failed to connect to the database"); // Show an error message
            System.exit(1); // Exit the application with an error status
        }
    }

    // Override the actionPerformed method to handle button click events
    @Override
    public void actionPerformed(ActionEvent e) {
        // Open the corresponding dialog based on which button was clicked
        if (e.getSource() == addVideoButton) {
            AddVideoDialog addVideoDialog = new AddVideoDialog(this, conn);
            addVideoDialog.setVisible(true);
        } else if (e.getSource() == updateVideoButton) {
            UpdateVideoDialog updateVideoDialog = new UpdateVideoDialog(this, conn);
            updateVideoDialog.setVisible(true);
        } else if (e.getSource() == deleteVideoButton) {
            DeleteVideoDialog deleteVideoDialog = new DeleteVideoDialog(this, conn);
            deleteVideoDialog.setVisible(true);
        } else if (e.getSource() == addMovieButton) {
            AddMovieDialog addMovieDialog = new AddMovieDialog(this, conn);
            addMovieDialog.setVisible(true);
        } else if (e.getSource() == updateMovieButton) {
            UpdateMovieDialog updateMovieDialog = new UpdateMovieDialog(this, conn);
            updateMovieDialog.setVisible(true);
        } else if (e.getSource() == deleteMovieButton) {
            DeleteMovieDialog deleteMovieDialog = new DeleteMovieDialog(this, conn);
            deleteMovieDialog.setVisible(true);
        } else if (e.getSource() == addTVSeriesButton) {
            AddTVSeriesDialog addTVSeriesDialog = new AddTVSeriesDialog(this, conn);
            addTVSeriesDialog.setVisible(true);
        } else if (e.getSource() == updateTVSeriesButton) {
            UpdateTVSeriesDialog updateTVSeriesDialog = new UpdateTVSeriesDialog(this, conn);
            updateTVSeriesDialog.setVisible(true);
        } else if (e.getSource() == deleteTVSeriesButton) {
            DeleteTVSeriesDialog deleteTVSeriesDialog = new DeleteTVSeriesDialog(this, conn);
            deleteTVSeriesDialog.setVisible(true);
        }
    }

    // Main method to launch the application
    public static void main(String[] args) {
        SwingUtilities.invokeLater(AdminPanelManager::new); // Create and show the GUI on the Event Dispatch Thread
    }
}
