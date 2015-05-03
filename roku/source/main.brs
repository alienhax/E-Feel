' ********************************************************************
' **  EWM Roku channel
' **
' **  Copyright (c) 2015 EWM Realty International All Rights Reserved.
' **  Author: David Cruz
' ********************************************************************


Sub Main()

    InitTheme()
    screen = CreateObject("roListScreen")
    port = CreateObject("roMessagePort")
    screen.SetMessagePort(port)
    screen.SetHeader("Welcome to the E-Feel Roku App")
    screen.SetBreadcrumbText("Menu", "Menu")
    
    contentList = InitContentList()
    screen.SetContent(contentList)
    screen.show()
    
    'main app loop
    While (True)
        
        msg = wait(0, port)
        
        If (type(msg) = "roListScreenEvent")
            
            If (msg.isListItemFocused())
                screen.SetBreadcrumbText("Menu", contentList[msg.GetIndex()].Title)            
            Endif
            
            'Get appropriate app action for OK button press
            isOKBtnPressed =  (msg.GetType() = 0)
            If(isOKBtnPressed)
                buttonIndex = msg.GetIndex()
                If buttonIndex = 0 
                    'SlideShow
                    arrVideos = CreateObject("roAssociativeArray")
                    arrVideos.url = "http://e-feel.club/uploaded_images/final.mp4"
                    arrVideos.StreamFormat = "mp4"
                    arrVideos.title = "E-Feel video"
                    displayVideo(arrVideos)       
                EndIf
                
            End If
        
        Endif
    
    End While
    
End Sub

REM ******************************************************
REM
REM Setup theme for the application 
REM
REM ******************************************************
Sub SetTheme()
    app = CreateObject("roAppManager")
    theme = CreateObject("roAssociativeArray")

    theme.OverhangOffsetSD_X = "72"
    theme.OverhangOffsetSD_Y = "25"
    theme.OverhangSliceSD = "pkg:/images/Overhang_BackgroundSlice_Black_SD43.png"
    theme.OverhangLogoSD  = "pkg:/images/Logo_Overhang_EWM_SD43.png"

    theme.OverhangOffsetHD_X = "123"
    theme.OverhangOffsetHD_Y = "48"
    theme.OverhangSliceHD = "pkg:/images/Overhang_BackgroundSlice_RED_HD.png"
    theme.OverhangLogoHD  = "pkg:/images/Logo_Overhang_EWM_HD.png"

    app.SetTheme(theme)
End Sub


REM ******************************************************
REM
REM initContentList 
REM
REM ******************************************************
Function initContentList() As Object

    contentList = [
        {
            Title: "View your video(s)",
            ID: "1",
            SDSmallIconUrl: "pkg:/assets/Slideshow_Icon-35.png",
            HDSmallIconUrl: "pkg:/assets/Slideshow_Icon-35.png",
            HDBackgroundImageUrl: "pkg:/assets/Slideshow_Detail_Graphic-516_x_366.png",
            SDBackgroundImageUrl: "pkg:/assets/Slideshow_Detail_Graphic-516_x_366.png",            
            ShortDescriptionLine1: "Slideshow",
            ShortDescriptionLine2: "Your videos"
        }
    ]
    Return contentList
End Function


REM ******************************************************
REM
REM InitTheme 
REM
REM ******************************************************
Function InitTheme() as void
    app = CreateObject("roAppManager")

    primaryText                 = "#FFFFFF"
    secondaryText               = "#707070"
    'buttonText                  = "#C0C0C0"
    'buttonHighlight             = "#FFFFFF"
    backgroundColor             = "#E0E0E0"
    
    theme = {
        BackgroundColor: backgroundColor
        OverhangSliceHD: "pkg:/images/Overhang_BackgroundSlice_GRAY_HD.png"
        OverhangSliceSD: "pkg:/images/Overhang_BackgroundSlice_Black_SD43.png"
        OverhangLogoHD: "pkg:/assets/HD_App_Logo-163x165.png"
        OverhangLogoSD: "pkg:/assets/SD_App_Logo-92x83-01.png"
        OverhangOffsetSD_X: "0"
        OverhangOffsetSD_Y: "0"
        OverhangOffsetHD_X: "0"
        OverhangOffsetHD_Y: "0"
        BreadcrumbTextLeft: "#52202A"
        BreadcrumbTextRight: "#000000"
        BreadcrumbDelimiter: "#000000"
        ThemeType: "generic-dark"
        ListItemText: secondaryText
        ListItemHighlightText: primaryText
        ListScreenDescriptionText: secondaryText
        ListItemHighlightHD: "pkg:/images/select_bkgnd.png"
        ListItemHighlightSD: "pkg:/images/select_bkgnd.png"        
    }
    app.SetTheme( theme )
End Function
