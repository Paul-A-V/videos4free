package com.mycompany.adminpanelmanager;

import javax.swing.*;
import java.awt.*;
import java.awt.event.*;
import java.sql.*;

public class AdminPanel extends JFrame implements ActionListener {
    private JButton addButton, updateButton, deleteButton;
    private Connection conn;

    public AdminPanel() {
        super("Admin Panel");
        initializeGUI();
        connectToDatabase();
    }

    private void initializeGUI() {
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLayout(new FlowLayout());

        addButton = new JButton("Add Video");
        updateButton = new JButton("Update Video");
        deleteButton = new JButton("Delete Video");

        addButton.addActionListener(this);
        updateButton.addActionListener(this);
        deleteButton.addActionListener(this);

        add(addButton);
        add(updateButton);
        add(deleteButton);

        pack();
        setLocationRelativeTo(null);
        setVisible(true);
    }

    private void connectToDatabase() {
        try {
            String url = "jdbc:mysql://localhost:3306/videos4free";
            String username = "root";
            String password = "";

            conn = DriverManager.getConnection(url, username, password);
        } catch (SQLException e) {
            e.printStackTrace();
            JOptionPane.showMessageDialog(null, "Failed to connect to the database");
            System.exit(1);
        }
    }

    @Override
    public void actionPerformed(ActionEvent e) {
        if (e.getSource() == addButton) {
            // Open a new window or dialog for adding a video
            AddVideoDialog addVideoDialog = new AddVideoDialog(this, conn);
            addVideoDialog.setVisible(true);
        } else if (e.getSource() == updateButton) {
            // Open a new window or dialog for updating a video
            UpdateVideoDialog updateVideoDialog = new UpdateVideoDialog(this, conn);
            updateVideoDialog.setVisible(true);
        } else if (e.getSource() == deleteButton) {
            // Open a new window or dialog for deleting a video
            DeleteVideoDialog deleteVideoDialog = new DeleteVideoDialog(this, conn);
            deleteVideoDialog.setVisible(true);
        }
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(AdminPanel::new);
    }
}
