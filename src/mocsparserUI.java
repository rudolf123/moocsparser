/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Владимир
 */
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import java.io.IOException;
import java.io.InputStream;
import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.nio.charset.Charset;
import java.awt.*;
import javax.swing.*;
import java.util.Vector;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;



public class mocsparserUI extends javax.swing.JFrame{

    private TaskParsingEdx task;
    private TaskParsingMoocList taskMooclist;
    private Connection MySQLConnection = null;
    private boolean connectedtodb = false;
    /**
     * Creates new form mocsparserUI
     */
    public mocsparserUI() {
        initComponents();
    }
    
    class mySQLConnectionInfo{
        public mySQLConnectionInfo()
        {
            serverName = "";
            database = "";
            url = "jdbc:mysql://" + serverName + "/" + database;
            username = "";
            password = "";
        }
        String serverName;
        String database;
        String url;
        String username;
        String password;
    }
    private boolean connecttoMySQL(mySQLConnectionInfo connectioninfo){
        try {
            // Название драйвера
            String driverName = "com.mysql.jdbc.Driver"; 
            Class.forName(driverName);
            if (connectioninfo.url == "")
                connectioninfo.url = "jdbc:mysql://" + connectioninfo.serverName + "/" + connectioninfo.database;
            MySQLConnection = DriverManager.getConnection(connectioninfo.url, connectioninfo.username, connectioninfo.password);

        } // end try
        catch (ClassNotFoundException e) {
                e.printStackTrace();
                
                return false;
        }catch (SQLException e) {
                e.printStackTrace();
                
                return false;
                // Could not find the database driver
        } 

        return true;
    }
    private boolean InserttoDB(Info info){
        if (info == null)
            return false;
        boolean rs = false;
        try {
                info.replaceAll("'", "\\\\'");
                String query = "INSERT INTO `moocsdb"
                        +"`.`courses` "
                        + "(`id`, `title`, `schoolname`, `platform`, `start`, `length`, `estimate`, `language`, `subtitles`, `about`, `staff`, `staff_profile`, `info`, `similar`) VALUES"
                        + "(NULL, '" + info.title + "', '" + info.schoolname + "', '" + info.platform + "', '" + info.start + "', '" + info.length + "', '" + info.estimate + "', '" + info.language + "', '" + info.subtitles + "',"
                        + " '" + info.about + "', '" + info.staff + "', '" + info.staff_profile + "', '" + info.info + "', '" + info.similar + "');";
                Statement stmt = MySQLConnection.createStatement();

                rs = stmt.execute(query);
        } catch (SQLException e) {
                LogArea.append("!!!!Ошибка при добавлении в БД!!!! - " + e.toString() + "\n"); 
                e.printStackTrace();
                
                return rs;
                // Could not connect to the database
        }
        return true;
    }

    class InfoMoodle{
            public InfoMoodle(){
            id = -1;
            title = "";
            url = "";
        }
        int id;
        String title;
        String url;
    }
    class Info{
        public Info(){
            schoolname = "";
            platform = "";
            title = "";
            start = "";
            length = "";
            estimate = "";
            language = "";
            subtitles = "";
            about = "";
            staff = "";
            staff_profile = "";
            info = "";
            similar = "";
        }
        @Override
        public String toString (){
            String res = "    \"title\": \"" + this.title + "\"\n" + 
                        "    \"platform\": \"" + this.platform + "\"\n" + 
                        "    \"university\": \"" + this.schoolname + "\"\n" + 
                        "    \"start\": \"" + this.start + "\"\n" + 
                        "    \"length\": \"" + this.length + "\"\n" + 
                        "    \"estimate\": \"" + this.estimate + "\"\n" + 
                        "    \"staff\": \"" + this.staff + "\"\n" +
                        "    \"staff_profile\": \"" + this.staff_profile + "\"\n" +
                        "    \"similar\": \"" + this.similar + "\"\n" +
                        "    \"language\": \"" + this.language + "\"\n" +
                        "    \"subtitles\": \"" + this.subtitles + "\"\n" +
                        "    \"description\": \"" + this.about + "\"\n" +
                        "    \"info\": \"" + this.info + "\"\n";
            return res;
        }
        public void replaceAll(String pattern, String replacement){
            schoolname = schoolname.replaceAll(pattern, replacement);
            platform = platform.replaceAll(pattern, replacement);
            title = title.replaceAll(pattern, replacement);
            start = start.replaceAll(pattern, replacement);
            length = length.replaceAll(pattern, replacement);
            estimate = estimate.replaceAll(pattern, replacement);
            language = language.replaceAll(pattern, replacement);
            subtitles = subtitles.replaceAll(pattern, replacement);
            about = about.replaceAll(pattern, replacement);
            staff = staff.replaceAll(pattern, replacement);
            staff_profile = staff_profile.replaceAll(pattern, replacement);
            similar = similar.replaceAll(pattern, replacement);
            info = info.replaceAll(pattern, replacement);
        } 
        String schoolname;
        String platform;
        String title;
        String start;
        String length;
        String estimate;
        String language;
        String subtitles;
        String about;
        String staff;
        String staff_profile;
        String similar;
        String info;
    }

    private Info parseMoocListCourse(String url){
        Info info = new Info(); 
        Document doc_courses = null;
        try {
            doc_courses = Jsoup.connect(url).timeout(5*1000).userAgent("Mozilla").get();
        } catch (IOException e) {
            LogArea.append("!!!!Ошибка!!!! - " + e.toString() + "\n"); 
            return null;
        }
        info.title = doc_courses.select("h1[id=page-title]").text();
        info.platform = doc_courses.select("div[class=field field-name-field-initiative field-type-taxonomy-term-reference field-label-above clearfix]").select("a").first().text();
        info.schoolname = doc_courses.select("div[class=field field-name-field-university-entity field-type-taxonomy-term-reference field-label-above clearfix]").select("a").first().text();
        Element staff = doc_courses.select("div[class=field field-name-field-instructors field-type-taxonomy-term-reference field-label-above clearfix]").first();
        Elements staffs = staff.select("li");
        for (Element staff_person: staffs)
        {
            info.staff += staff_person.select("a").first().text() + "; ";
            info.staff_profile += "http://www.mooc-list.com/" + staff_person.select("a").attr("href") + " ; ";
        }  
        info.about = doc_courses.select("div[class=section field field-name-body field-type-text-with-summary field-label-hidden]").text();
        info.start = doc_courses.select("div[class=section field field-name-field-start-date-text field-type-text field-label-above]").select("div[class=field-items]").text();
        info.length = doc_courses.select("div[class=field field-name-field-length field-type-taxonomy-term-reference field-label-above clearfix]").select("a").text();
        info.estimate = doc_courses.select("div[class=field field-name-field-estimated-effort field-type-taxonomy-term-reference field-label-above clearfix]").select("a").text();
        info.info = doc_courses.select("div[class=section field field-name-field-recommended-background field-type-text field-label-above]").text();
        info.language = doc_courses.select("div[class=field field-name-field-language field-type-taxonomy-term-reference field-label-above clearfix]").select("a").text();
        
        return info;
    }
    
    private Info parseEdxCourse(String url){
        Info info = new Info(); 
        info.platform = "edX";
        Document doc_courses = null;
        try {
            doc_courses = Jsoup.connect(url).get();
        } catch (IOException e) {
            LogArea.append("!!!!Ошибка!!!! - " + e.toString() + "\n"); 
            return null;
        }
        Element course_info = doc_courses.select("div[class=copy-detail course-detail-info views-fieldset]").first();
        Element school = course_info.select("div[class=course-detail-school item]").first();
        Elements staffs = doc_courses.select("div[class=course-staff-info views-fieldset]");
        for (Element staff_person: staffs)
        {
            info.staff += staff_person.select("h4[class=staff-title]").first().text() + "; ";
            info.staff_profile += info.staff + " - " + staff_person.select("div[class=staff-resume]").first().text() + "; ";
        }
        info.schoolname = school.select("a").first().html();
        info.title = doc_courses.select("h2[class=course-detail-title]").first().text();
        if (!course_info.select("div[class=course-detail-start item]").isEmpty())
            info.start = course_info.select("div[class=course-detail-start item]").first().text();
        if (!course_info.select("div[class=course-detail-length item]").isEmpty())
            info.length = course_info.select("div[class=course-detail-length item]").first().text();
        if (!course_info.select("div[class=course-detail-effort item]").isEmpty())
            info.estimate = course_info.select("div[class=course-detail-effort item]").first().text();
        info.about = doc_courses.select("div[class=course-section course-detail-about]").first().text();

        return info;
    }
    
    private Info parseCourseraCourse(String url){
        Info info = new Info(); 
        Document doc_courses = null;
        try {
            doc_courses = Jsoup.connect(url).get();
            LogArea.append(doc_courses.html());
        } catch (IOException e) {
            LogArea.append("!!!!Ошибка!!!! - " + e.toString() + "\n"); 
            return null;
        }
        info.info = doc_courses.html();
        //info.info = doc_courses.select("div[class=coursera-course2-data coursera-course2-course-at-glance]").first().html();
        Elements staffs = doc_courses.select("div[class=coursera-course2-instructors-profile]");
        if (!staffs.isEmpty())
        {
            for (Element staff: staffs)
            {
                String ref = staff.select("a").first().attr("href");
                info.staff += staff.text() + "\n" + ref + "\n";
            }
        }
        Elements similars = doc_courses.select("div[coursera-similartopics-course-name]");
        if (!similars.isEmpty())
        {
            for (Element similar: similars)
            {
                String ref = similar.select("a").first().attr("href");
                info.similar += similar.text() + "\n" + ref + "\n";;
            }
        }

        //info.about = doc_courses.select("div[class=coursera-course-detail]").first().text();

        return info;
    }
    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        jPanel2 = new javax.swing.JPanel();
        buConnectToDB = new javax.swing.JButton();
        jTextField1 = new javax.swing.JTextField();
        jTextField2 = new javax.swing.JTextField();
        jLabel1 = new javax.swing.JLabel();
        jLabel2 = new javax.swing.JLabel();
        jTextField3 = new javax.swing.JTextField();
        jLabel3 = new javax.swing.JLabel();
        jLabel4 = new javax.swing.JLabel();
        jTextField4 = new javax.swing.JTextField();
        jLabel5 = new javax.swing.JLabel();
        buStart = new javax.swing.JButton();
        buStop = new javax.swing.JButton();
        ProgressBar = new javax.swing.JProgressBar();
        jScrollPane1 = new javax.swing.JScrollPane();
        LogArea = new javax.swing.JTextArea();
        jCheckBox1 = new javax.swing.JCheckBox();
        buMoodlestart = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);

        buConnectToDB.setText("Соединиться с БД");
        buConnectToDB.setToolTipText("");
        buConnectToDB.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                buConnectToDBActionPerformed(evt);
            }
        });

        jTextField1.setText("localhost");

        jTextField2.setText("root");

        jLabel1.setText("Сервер MySQL");

        jLabel2.setText("Имя пользователя");

        jLabel3.setText("Пароль");

        jLabel4.setText("Нет соединения");

        jTextField4.setText("moocsdb");
        jTextField4.setToolTipText("");

        jLabel5.setText("Имя БД");

        buStart.setText("Пуск");
        buStart.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                buStartActionPerformed(evt);
            }
        });

        buStop.setText("Стоп");
        buStop.setToolTipText("");
        buStop.setEnabled(false);
        buStop.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                buStopActionPerformed(evt);
            }
        });

        ProgressBar.setToolTipText("");
        ProgressBar.addPropertyChangeListener(new java.beans.PropertyChangeListener() {
            public void propertyChange(java.beans.PropertyChangeEvent evt) {
                ProgressBarPropertyChange(evt);
            }
        });

        LogArea.setColumns(20);
        LogArea.setRows(5);
        LogArea.addPropertyChangeListener(new java.beans.PropertyChangeListener() {
            public void propertyChange(java.beans.PropertyChangeEvent evt) {
                LogAreaPropertyChange(evt);
            }
        });
        jScrollPane1.setViewportView(LogArea);

        jCheckBox1.setText("Использовать ссылки из кэша");
        jCheckBox1.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                jCheckBox1ActionPerformed(evt);
            }
        });

        buMoodlestart.setText("Загрузить курсы moodle");
        buMoodlestart.setToolTipText("");
        buMoodlestart.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                buMoodlestartActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout jPanel2Layout = new javax.swing.GroupLayout(jPanel2);
        jPanel2.setLayout(jPanel2Layout);
        jPanel2Layout.setHorizontalGroup(
            jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(jPanel2Layout.createSequentialGroup()
                .addContainerGap()
                .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                    .addGroup(jPanel2Layout.createSequentialGroup()
                        .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING, false)
                            .addComponent(jTextField1, javax.swing.GroupLayout.DEFAULT_SIZE, 155, Short.MAX_VALUE)
                            .addComponent(jLabel1)
                            .addComponent(jLabel4)
                            .addComponent(jTextField4))
                        .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                            .addGroup(jPanel2Layout.createSequentialGroup()
                                .addGap(13, 13, 13)
                                .addComponent(jLabel2))
                            .addGroup(jPanel2Layout.createSequentialGroup()
                                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                                .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
                                    .addComponent(jLabel3)
                                    .addComponent(jTextField2, javax.swing.GroupLayout.PREFERRED_SIZE, 155, javax.swing.GroupLayout.PREFERRED_SIZE)
                                    .addComponent(jTextField3, javax.swing.GroupLayout.PREFERRED_SIZE, 155, javax.swing.GroupLayout.PREFERRED_SIZE)))))
                    .addComponent(jLabel5)
                    .addComponent(buConnectToDB, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
            .addGroup(jPanel2Layout.createSequentialGroup()
                .addComponent(buStart)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(buStop)
                .addGap(18, 18, 18)
                .addComponent(jCheckBox1)
                .addGap(75, 75, 75)
                .addComponent(buMoodlestart)
                .addGap(0, 0, Short.MAX_VALUE))
            .addComponent(ProgressBar, javax.swing.GroupLayout.DEFAULT_SIZE, 874, Short.MAX_VALUE)
            .addComponent(jScrollPane1)
        );
        jPanel2Layout.setVerticalGroup(
            jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, jPanel2Layout.createSequentialGroup()
                .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jLabel1)
                    .addComponent(jLabel2))
                .addGap(5, 5, 5)
                .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jTextField1, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jTextField2, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jLabel5)
                    .addComponent(jLabel3))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED)
                .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(jTextField4, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                    .addComponent(jTextField3, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(buConnectToDB)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(jLabel4)
                .addGap(15, 15, 15)
                .addGroup(jPanel2Layout.createParallelGroup(javax.swing.GroupLayout.Alignment.BASELINE)
                    .addComponent(buStart)
                    .addComponent(buStop)
                    .addComponent(jCheckBox1)
                    .addComponent(buMoodlestart))
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(ProgressBar, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.UNRELATED)
                .addComponent(jScrollPane1, javax.swing.GroupLayout.PREFERRED_SIZE, 287, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap(javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
        );

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(jPanel2, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addComponent(jPanel2, javax.swing.GroupLayout.PREFERRED_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.PREFERRED_SIZE)
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    class TaskParsingStudyPgta extends SwingWorker<Void, Void> {
        /*
         * Main task. Executed in background thread.
         */
        private boolean getLinksFromCache = false;
        private Vector links;
        private Vector category_links;
        private int progress = 0;
        private float fProgress = 0;
        private Document doc = null;
        private Element next;
        private float step;
        
        public TaskParsingStudyPgta(boolean usecache){
            if (usecache == true)
            {
                getLinksFromCache = usecache;
            }
            else
            {
                links = new Vector();
                category_links = new Vector();
            }
        }
        
        private boolean getCoursesLinksFromCache(){
            links = new Vector();
            InputStream    fis = null;
            BufferedReader br;
            String         line;
            try {
                fis = new FileInputStream("D:\\Documents and Settings\\Владимир\\Рабочий стол\\moocsparser_java\\repo\\linkscache.txt");
            }catch (IOException e){
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                return false;
            }
            br = new BufferedReader(new InputStreamReader(fis, Charset.forName("UTF-8")));
            try {
                while ((line = br.readLine()) != null) {
                    LogArea.append(line + "\n");
                    links.add(line);
                }
            }catch (IOException e){
                LogArea.append("!!!!Ошибка!!!! - " + e.toString() + "\n");
                return false;
            }

            // Done with the file
            try {
                br.close();
            }catch (IOException e){
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                return false;
            }
            
            br = null;
            fis = null;
            
            return true;
        }
        
        private boolean getCoursesLinks(){
            ProgressBar.setString("Cобираем ссылки на курсы с http://study.pgta.ru/");
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            try {
                doc = Jsoup.connect("http://study.pgta.ru/course/index.php").userAgent("Mozilla").get();
            } catch (IOException e) {
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
            }
            Elements course_categories = doc.select("td[class=category name]").select("a");
            for(Element course_category : course_categories)
            {
                String s = course_category.attr("href");
                LogArea.append(s + "\n");
                category_links.add(s);
            }
            int catNum = category_links.toArray().length;
            LogArea.append("catNum = " + Integer.toString(catNum));
            step = 100f/catNum;
            //all
            
            for (Object link:category_links)
            {
                doc.empty();
                try {
                    doc = Jsoup.connect(link.toString()).timeout(5*1000).userAgent("Mozilla").get();
                    //LogArea.append(doc.html() + "\n");
                } catch (IOException e) {
                    LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                    
                    continue;
                }
                Elements course_titles = null;
                InfoMoodle info = new InfoMoodle();
                if (!doc.select("table[class=generalbox boxaligncenter]").isEmpty())
                {
                    course_titles = doc.select("table[class=generalbox boxaligncenter]").select("a");
                    for(Element course_title : course_titles)
                    {
                        String tmp="";
                        if (course_title.attr("href").contains("view.php"))
                        {
                            if(course_title.select("img").isEmpty())
                            {
                                String href = course_title.attr("href");
                                int id = Integer.parseInt(href.substring(href.indexOf("=")+1));
                                tmp = course_title.ownText() + "; id = " + Integer.toString(id);
                                LogArea.append(tmp + "\n");
                                links.add(tmp);
                                info.id = id;
                                info.title = course_title.ownText();
                                info.url = "http://study.pgta.ru/course/" + href;
                                
                                boolean rs;
                                try {
                                        info.title = info.title.replaceAll("'", "\\\\'");
                                        String query = "INSERT INTO `moocsdb"
                                                + "`.`courses_moodle` "
                                                + "(`moodle_id`, `url`, `title`) VALUES"
                                                + "('" + Integer.toString(info.id) + "', '" + info.url + "', '" + info.title + "');";
                                        Statement stmt = MySQLConnection.createStatement();

                                        rs = stmt.execute(query);
                                } catch (SQLException e) {
                                        LogArea.append("!!!!Ошибка при добавлении в БД!!!! - " + e.toString() + "\n"); 
                                        e.printStackTrace();
                                }
                            }
                        }
                    }
                }
                
                if (!doc.select("div[class=courseboxes box]").isEmpty())
                {
                    course_titles = doc.select("div[class=name]").select("a");
                    for(Element course_title : course_titles)
                    {
                        String tmp="";
                        if (course_title.attr("href").contains("view.php"))
                        {
                            String href = course_title.attr("href");
                            int id = Integer.parseInt(href.substring(href.indexOf("=")+1));
                            tmp = course_title.ownText() + "; id = " + Integer.toString(id);
                            LogArea.append(tmp + "\n");
                            links.add(tmp);
                            
                            info.id = id;
                            info.title = course_title.ownText();
                            info.url = href;
                            
                            boolean rs = false;
                            try {
                                    info.title = info.title.replaceAll("'", "\\\\'");
                                    String query = "INSERT INTO `moocsdb"
                                            + "`.`courses_moodle` "
                                            + "(`moodle_id`, `title`, `url`) VALUES"
                                            + "('" + info.id + "', '" + info.title + "', '" + info.url + "');";
                                    Statement stmt = MySQLConnection.createStatement();

                                    rs = stmt.execute(query);
                            } catch (SQLException e) {
                                    LogArea.append("!!!!Ошибка при добавлении в БД!!!! - " + e.toString() + "\n"); 
                                    e.printStackTrace();
                            }
                            
                            if (rs == true)
                                LogArea.append("Запись добавлена!");
                        }
                    }
                }
                
                /**/
                fProgress += step;
                progress = Math.round(fProgress); 
                ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            }
            
            ProgressBar.setString("Готово");
            progress = 100; 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            
            return true;
        }
        
        @Override
        public Void doInBackground() {
            if (getLinksFromCache == false)
                getCoursesLinks();
            else
                getCoursesLinksFromCache();
            
            return null;
        }
        /*
         * Executed in event dispatching thread
         */
        @Override
        public void done() {
            buMoodlestart.setEnabled(true);
        }
    }
        
    class TaskParsingMoocList extends SwingWorker<Void, Void> {
        /*
         * Main task. Executed in background thread.
         */
        private boolean getLinksFromCache = false;
        private Vector links;
        private Vector category_links;
        private int progress = 0;
        private float fProgress = 0;
        private Document doc = null;
        private Element next;
        private float step;
        
        public TaskParsingMoocList(boolean usecache){
            if (usecache == true)
            {
                getLinksFromCache = usecache;
            }
            else
            {
                links = new Vector();
                category_links = new Vector();
            }
        }
        
        private boolean getCoursesLinksFromCache(){
            links = new Vector();
            InputStream    fis = null;
            BufferedReader br;
            String         line;
            try {
                fis = new FileInputStream("D:\\Documents and Settings\\Владимир\\Рабочий стол\\moocsparser_java\\repo\\linkscache.txt");
            }catch (IOException e){
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                return false;
            }
            br = new BufferedReader(new InputStreamReader(fis, Charset.forName("UTF-8")));
            try {
                while ((line = br.readLine()) != null) {
                    LogArea.append(line + "\n");
                    links.add(line);
                }
            }catch (IOException e){
                LogArea.append("!!!!Ошибка!!!! - " + e.toString() + "\n");
                return false;
            }

            // Done with the file
            try {
                br.close();
            }catch (IOException e){
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                return false;
            }
            
            br = null;
            fis = null;
            
            return true;
        }
        
        private boolean getCoursesLinks(){
            ProgressBar.setString("Cобираем ссылки на курсы с http://www.mooc-list.com");
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            try {
                doc = Jsoup.connect("http://www.mooc-list.com/").userAgent("Mozilla").get();
            } catch (IOException e) {
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
            }
            Elements course_categories = doc.select("div[id=block-menu-menu-categories]").select("a");
            for(Element course_category : course_categories)
            {
                String s = "http://www.mooc-list.com" + course_category.attr("href");
                LogArea.append(s + "\n");
                category_links.add(s);
            }
            int catNum = category_links.toArray().length;
            LogArea.append("catNum = " + Integer.toString(catNum));
            step = 100f/catNum;
            //all
            
            for (Object link:category_links)
            {
                doc.empty();
                try {
                    doc = Jsoup.connect(link.toString()).timeout(5*1000).userAgent("Mozilla").get();
                    //LogArea.append(doc.html() + "\n");
                } catch (IOException e) {
                    LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                    
                    continue;
                }
                Elements course_titles = doc.select("div[id=block-system-main]").first().select("div[class=view-content]").select("a");
                for(Element course_title : course_titles)
                {
                    String tmp = "http://www.mooc-list.com" + course_title.attr("href");;
                    LogArea.append(tmp + "\n");
                    links.add(tmp);
                }
                while (!doc.select("div[id=block-system-main]").select("li[class=pager-next]").isEmpty())
                {
                    next = doc.select("div[id=block-system-main]").select("li[class=pager-next]").first();
                    String s = next.select("a").first().attr("href");
                    doc.empty();
                    try {
                        doc = Jsoup.connect("http://www.mooc-list.com" + s).timeout(5*1000).userAgent("Mozilla").get();
                    } catch (IOException e) {
                        LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                        
                        continue;
                    }
                    course_titles = doc.select("div[id=block-system-main]").first().select("div[class=view-content]").select("a");
                    for(Element course_title : course_titles)
                    {
                        String tmp = "http://www.mooc-list.com" + course_title.attr("href");;
                        LogArea.append(tmp + "\n");
                        links.add(tmp);
                    }
                }
                fProgress += step;
                progress = Math.round(fProgress); 
                ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            }
            
            ProgressBar.setString("Готово");
            progress = 100; 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            
            return true;
        }
        
        @Override
        public Void doInBackground() {
            if (getLinksFromCache == false)
                getCoursesLinks();
            else
                getCoursesLinksFromCache();
            progress = 0; 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            ProgressBar.setString("Cобираем описания курсов с http://www.mooc-list.com");
            //вычисляем шаг для прогресса и пошагово открываем все ссылки
            int courseNum = links.toArray().length;
            LogArea.append("CoursesNum = " + Integer.toString(courseNum));
            step = 100f/courseNum;
            LogArea.append("step = " + Float.toString(step));

            for (Object link: links)
            {
                Info info = null;
                info = parseMoocListCourse(link.toString());
                if (InserttoDB(info))
                    LogArea.append("Запись добавлена!" + "\n");
                else
                    LogArea.append("Ошибка! - Невозможно добавить запись" + link.toString() + "\n");
                
                fProgress += step;
                progress = Math.round(fProgress); 
                ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            }
            ProgressBar.setString("Готово");
            progress = 100; 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            
            return null;
        }
        /*
         * Executed in event dispatching thread
         */
        @Override
        public void done() {
            buStart.setEnabled(true);
            buStop.setEnabled(false);
        }
    }
    
        
    class TaskParsingEdx extends SwingWorker<Void, Void> {
        /*
         * Main task. Executed in background thread.
         */
        @Override
        public Void doInBackground() {
            int progress = 0;
            float fProgress = 0;
            Document doc = null;
            Element next;
            Vector links = new Vector(); 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            try {
                doc = Jsoup.connect("https://www.edx.org/course-list").get();
            } catch (IOException e) {
                LogArea.append("!!!!Ошибка!!!! - " + e.toString() + "\n");
            }
            boolean check1 = doc.select("li[class=pager-next odd]").isEmpty();
            boolean check2 = doc.select("li[class=pager-next even]").isEmpty();
            Elements course_titles = doc.select("h2[class=title course-title]");
            
            ProgressBar.setString("Cобираем ссылки на курсы с https://www.edx.org/");
            for(Element course_title : course_titles)
            {
                String s = course_title.select("a").first().attr("href");
                LogArea.append(s + "\n");
                links.add(s);
            }

            //собираем ссылки на курсы
            while (!doc.select("li[class=pager-next odd]").isEmpty())
            {
                next = doc.select("li[class=pager-next odd]").first();
                String s = next.select("a").first().attr("href");
                doc.empty();
                try {
                    doc = Jsoup.connect("https://www.edx.org" + s).get();
                } catch (IOException e) {
                    LogArea.append("!!!!Ошибка!!!! - " + e.toString() + "\n");
                }
                course_titles = doc.select("h2[class=title course-title]");
                for(Element course_title : course_titles)
                {
                    String tmp = course_title.select("a").first().attr("href");
                    LogArea.append(tmp + "\n");
                    links.add(tmp);
                }
            }
            
            //вычисляем шаг для прогресса и пошагово открываем все ссылки
            int courseNum = links.toArray().length;
            float step = 100f/courseNum;
            ProgressBar.setString("Cобираем описания курсов с https://www.edx.org/");
            for (Object link: links)
            {
                Info info = null;
                //LogArea.append("{"+"\n");
                info = parseEdxCourse(link.toString());
                if (InserttoDB(info))
                    LogArea.append("Record Added!" + "\n");
                else
                    LogArea.append("Error! - Can't add record" + "\n");
                fProgress += step;
                progress = Math.round(fProgress); 
                ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            }
            progress = 100; 
            ProgressBar.setString("Готово");
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            return null;
        }
        

        /*
         * Executed in event dispatching thread
         */
        @Override
        public void done() {
            buStart.setEnabled(true);
            buStop.setEnabled(false);
        }
        
    }
    
    class TaskParsingMyeducationkey extends SwingWorker<Void, Void> {
        /*
         * Main task. Executed in background thread.
         */
        @Override
        public Void doInBackground() {
            int progress = 0;
            float fProgress = 0;
            //Initialize progress property.
            setProgress(0);
            Document doc = null;
            Document courses_doc = null;
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            try {
                doc = Jsoup.connect("http://www.myeducationkey.com/").get();
            } catch (IOException e) {
                LogArea.append("!!!!Ошибка!!!! - " + e.toString());
            }
            Element university_education = doc.select("#subject-base").first(); 
            Elements specs = university_education.select("a.box-title");
            int specNum = specs.toArray().length;
            float step = 100/specNum;
            int departmentNum = -1;
            float departmentStep;
            int coursesNum = -1;
            float coursesStep;
            for(Element spec : specs)
            {
                doc.empty();
                try {
                    doc = Jsoup.connect(spec.attr("href")).get();
                } catch (IOException e) {
                    LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                }
                String spec_title = doc.select("a.title").first().html().toString();
                Elements departments = doc.select("a.department-img-title");
                
                departmentNum = departments.toArray().length;
                departmentStep =  step/departmentNum;
                for (Element department: departments)
                {
                    if (courses_doc!=null)
                        courses_doc.empty();

                    try {
                        courses_doc = Jsoup.connect(department.attr("href")).get();
                    } catch (IOException e) {
                        LogArea.append("!!!!Ошибка!!!! - " + e.toString());
                    }
                    Elements courses = courses_doc.select("div#main-sub-dpm-base");
                    coursesNum = courses.toArray().length;
                    coursesStep = departmentStep/coursesNum;
                    for (Element course: courses)
                    {
                        String course_from = course.select("div.sub-dpm-sub-title").first().html().toString();
                        Element course_title = course.select("a.sub-dpm-title").first();
                        courses_doc.empty();
                        try {
                            courses_doc = Jsoup.connect(course_title.attr("href")).get();
                        } catch (IOException e) {
                            LogArea.append("!!!!Ошибка!!!! - " + e.toString());

                            continue;
                        } 
                        String course_desc = courses_doc.select("div.text").first().html().toString().replaceAll("\r\n", " ");
                        LogArea.append("    \"speciality\": \"" + spec_title + "\"," + " \n");
                        LogArea.append("    \"department\": \"" + department.html().toString() + "\"," + " \n");
                        LogArea.append("    \"title\": \"" + course_title.html().toString() + "\"," + " \n");
                        LogArea.append("    \"from\": \"" + course_from + "\"," + " \n");
                        LogArea.append("    \"description\": \"" + course_desc.trim() + "\"" + " \n");
                        LogArea.append("}," + " \n");
                      
                        fProgress += coursesStep;
                        progress = Math.round(fProgress); 
                        ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
                    }
                }
            }
            progress = 100; 
            ProgressBar.firePropertyChange("progress",ProgressBar.getValue(),progress);
            return null;
        }
        

        /*
         * Executed in event dispatching thread
         */
        @Override
        public void done() {
            Toolkit.getDefaultToolkit().beep();
            buStart.setEnabled(true);
            buStop.setEnabled(false);
            setCursor(null); //turn off the wait cursor
            LogArea.append("Done!\n");
        }
    }
    
    private void buStartActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_buStartActionPerformed
        if (!connectedtodb){
            JOptionPane.showMessageDialog(jPanel2,
                                            "Нет подключения к БД",
                                            "Внимание!",
                                            JOptionPane.INFORMATION_MESSAGE);
        }
        else
        {
            ProgressBar.setStringPainted(true);
            //task = new TaskParsingEdx();
            //task.execute();
            taskMooclist = new TaskParsingMoocList(true);
            taskMooclist.execute();
            buStart.setEnabled(false);
            buStop.setEnabled(true);
        }
    }//GEN-LAST:event_buStartActionPerformed

    private void ProgressBarPropertyChange(java.beans.PropertyChangeEvent evt) {//GEN-FIRST:event_ProgressBarPropertyChange
        if ("progress" == evt.getPropertyName()) {
            int progress = (Integer) evt.getNewValue();
            ProgressBar.setValue(progress);
            
           // jTextArea1.append(String.format(
            //        "Completed %d%% of task.\n", progress));
        } 
    }//GEN-LAST:event_ProgressBarPropertyChange

    private void LogAreaPropertyChange(java.beans.PropertyChangeEvent evt) {//GEN-FIRST:event_LogAreaPropertyChange
        // TODO add your handling code here:
    }//GEN-LAST:event_LogAreaPropertyChange

    private void buStopActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_buStopActionPerformed
        boolean flag;
        flag = task.cancel(true);
        while (!flag)
            flag = task.cancel(true);
        buStop.setEnabled(false);
    }//GEN-LAST:event_buStopActionPerformed

    private void buConnectToDBActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_buConnectToDBActionPerformed
        try {
            mySQLConnectionInfo connectinfo = new mySQLConnectionInfo();
            connectinfo.serverName = jTextField1.getText();
            connectinfo.database = jTextField4.getText();
            connectinfo.username = jTextField2.getText();
            connectinfo.password = jTextField3.getText();
            
            if (connectedtodb == false)
            {
                if (connecttoMySQL(connectinfo))
                {
                    buConnectToDB.setText("Отсоединить");
                    LogArea.append("Соединено с БД: " + connectinfo.serverName +"/"+ connectinfo.database + "\n");
                    jLabel4.setText("Соединено!");
                    connectedtodb = true;
                }
            }
            else
            {
                MySQLConnection.close();
                connectedtodb = false;
                LogArea.append("Отсоединено от БД: " + connectinfo.serverName +"/"+ connectinfo.database + "\n");
                buConnectToDB.setText("Соединиться с БД");
                jLabel4.setText("Нет соединения!");
            }
        }catch (SQLException e) {
                e.printStackTrace();
        }
    }//GEN-LAST:event_buConnectToDBActionPerformed

    private void jCheckBox1ActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_jCheckBox1ActionPerformed
        // TODO add your handling code here:
    }//GEN-LAST:event_jCheckBox1ActionPerformed

    private void buMoodlestartActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_buMoodlestartActionPerformed
        if (!connectedtodb){
            JOptionPane.showMessageDialog(jPanel2,
                                            "Нет подключения к БД",
                                            "Внимание!",
                                            JOptionPane.INFORMATION_MESSAGE);
        }
        else
        {
            ProgressBar.setStringPainted(true);
            TaskParsingStudyPgta task_new = new TaskParsingStudyPgta(false);
            task_new.execute();
            buMoodlestart.setEnabled(false);
        }
    }//GEN-LAST:event_buMoodlestartActionPerformed

    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(mocsparserUI.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(mocsparserUI.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(mocsparserUI.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(mocsparserUI.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>
        java.util.logging.Logger.getLogger("com.gargoylesoftware.htmlunit").setLevel(Level.OFF);
        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new mocsparserUI().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JTextArea LogArea;
    private javax.swing.JProgressBar ProgressBar;
    private javax.swing.JButton buConnectToDB;
    private javax.swing.JButton buMoodlestart;
    private javax.swing.JButton buStart;
    private javax.swing.JButton buStop;
    private javax.swing.JCheckBox jCheckBox1;
    private javax.swing.JLabel jLabel1;
    private javax.swing.JLabel jLabel2;
    private javax.swing.JLabel jLabel3;
    private javax.swing.JLabel jLabel4;
    private javax.swing.JLabel jLabel5;
    private javax.swing.JPanel jPanel2;
    private javax.swing.JScrollPane jScrollPane1;
    private javax.swing.JTextField jTextField1;
    private javax.swing.JTextField jTextField2;
    private javax.swing.JTextField jTextField3;
    private javax.swing.JTextField jTextField4;
    // End of variables declaration//GEN-END:variables
}
