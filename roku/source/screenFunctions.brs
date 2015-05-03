REM ******************************************************
REM
REM onOK
REM
REM ******************************************************
Function onOK(selectedIndex as integer) as integer
    canvas = CreateObject("roImageCanvas")
    port = CreateObject("roMessagePort")
    canvas.SetMessagePort(port)
    canvasRect = canvas.GetCanvasRect()
    dlgRect = {x: 0, y: 0, w: 600, h: 300}
    btnRect = {x: 0, y: 0, w: 128, h: 80}    
    txtRect = {}
    txt = "Ball #" + stri(selectedIndex) + " Selected"
    fontRegistry = CreateObject("roFontRegistry")
    font = fontRegistry.GetDefaultFont()
    txtRect.w = font.GetOneLineWidth(txt, canvasRect.w)
    txtRect.h = font.GetOneLineHeight()
    txtRect.x = int((canvasRect.w - txtRect.w) / 2)
    txtRect.y = int((canvasRect.h - txtRect.h) / 2)
    dlgRect.x = int((canvasRect.w - dlgRect.w) / 2)
    dlgRect.y = int((canvasRect.h - dlgRect.h) / 2)
    btnRect.x = int((canvasRect.w - btnRect.w) / 2)
    btnRect.y = int((canvasRect.h +dlgRect.h) / 2) - btnRect.h - 15
    
    items = []
    items.Push({
        url: "pkg:/images/dialog.png"
        TargetRect: dlgRect
    })
    items.Push({
        Text: txt
        TextAttrs: { font: "large", color: "#a0a0a0" }
        TargetRect: txtRect
    })
    button = {
        url: "pkg:/images/button.png"
        TargetRect: btnRect
    }
    canvas.SetLayer(0, { Color: "#a0000000", CompositionMode: "Source_Over" })
    canvas.SetLayer(1, items)
    'canvas.SetLayer(2, button)
    canvas.Show()
    
    while true
        event = wait(0, port)
        if (event <> invalid)
            if (event.isRemoteKeyPressed())
                id = event.GetIndex()
                if (id = 6) OR (id = 0) 'OK or Back
                    canvas.Close()
                    return 1
                else if (id = 3)
                    button.url = "pkg:/images/button_pressed.png"
                    canvas.SetLayer(0, { Color: "#a0000000", CompositionMode: "Source_Over" })
                    canvas.SetLayer(0, items)
                    canvas.SetLayer(1, button)
                else if (id = 2)
                    button.url = "pkg:/images/button.png"
                    canvas.SetLayer(0, { Color: "#a0000000", CompositionMode: "Source_Over" })
                    canvas.SetLayer(0, items)
                    canvas.SetLayer(1, button)                
                endif
            endif            
        endif
    end while
    return 0
End Function

REM ******************************************************
REM
REM
REM ******************************************************
Function setDisplayOne(port as object)
    slideshow = CreateObject("roSlideShow")
    slideshow.SetMessagePort(port)
    slideshow.SetUnderscan(5.0)      ' shrink pictures by 5% to show a little bit of border (no overscan)
    slideshow.SetBorderColor("#6b4226")
    slideshow.SetMaxUpscale(8.0)
    slideshow.SetDisplayMode("best-fit")
    slideshow.SetPeriod(6)
    slideshow.Show()
    Return slideshow
End Function

REM ******************************************************
REM
REM
REM
REM ******************************************************
Function displayVideo(args As Dynamic)
    print "Displaying video: "
    p = CreateObject("roMessagePort")
    video = CreateObject("roVideoScreen")
    video.setMessagePort(p)

    'bitrates  = [0]          ' 0 = no dots, adaptive bitrate
    'bitrates  = [348]    ' <500 Kbps = 1 dot
    'bitrates  = [664]    ' <800 Kbps = 2 dots
    'bitrates  = [996]    ' <1.1Mbps  = 3 dots
    'bitrates  = [2048]    ' >=1.1Mbps = 4 dots
    bitrates  = [0]    

    'Swap the commented values below to play different video clips...
    urls = []
    qualities = ["HD"]
    StreamFormat = "mp4"
    title = "E-Feel video"
    'srt = "file://pkg:/source/craigventer.srt"
    srt = ""

    if type(args) = "roAssociativeArray"
        print "yes an roAssociativeArray"
        'if type(args.url) = "roString" and args.url <> "" then
        if args.url <> "" then
            urls[0] = args.url
	   end if
        'if type(args.StreamFormat) = "roString" and args.StreamFormat <> "" then
        if args.StreamFormat <> "" then
            StreamFormat = args.StreamFormat
        end if
        'if type(args.title) = "roString" and args.title <> "" then
        if args.title <> "" then
            title = args.title
        else 
            title = ""
        end if
        if type(args.srt) = "roString" and args.srt <> "" then
            srt = args.StreamFormat
        else 
            srt = ""
        end if
    end if
    
    videoclip = CreateObject("roAssociativeArray")
    videoclip.StreamBitrates = bitrates
    videoclip.StreamUrls = urls
    videoclip.StreamQualities = qualities
    videoclip.StreamFormat = StreamFormat
    videoclip.Title = title
    print "srt = ";srt
    if srt <> invalid and srt <> "" then
        videoclip.SubtitleUrl = srt
    end if
    
    video.SetContent(videoclip)
    video.show()

    lastSavedPos   = 0
    statusInterval = 10 'position must change by more than this number of seconds before saving

    while true
        msg = wait(0, video.GetMessagePort())
        if type(msg) = "roVideoScreenEvent"
            if msg.isScreenClosed() then 'ScreenClosed event
                print "Closing video screen"
                exit while
            else if msg.isPlaybackPosition() then
                'nowpos = msg.GetIndex()
                'if nowpos > 10000
                    
                'end if
                'if nowpos > 0
                '    if abs(nowpos - lastSavedPos) > statusInterval
                '        lastSavedPos = nowpos
                '    end if
                'end if
            else if msg.isRequestFailed()
                print "play failed: "; msg.GetMessage()
            else
                print "Unknown event: "; msg.GetType(); " msg: "; msg.GetMessage()
            endif
        end if
    	end while
End Function

REM ******************************************************
REM
REM search screen
REM
REM ******************************************************
Sub setSearchScreen()
    objPort = CreateObject("roMessagePort")
    objSrchScreen = CreateObject("roSearchScreen")
    objSrchScreen.SetMessagePort(objPort)
    'add btn
    objSrchScreen.Show()
    
     ' search screen main event loop
    displayHistory = True
    isDone = false
    arrHistory = CreateObject("roArray", 1, true)
    if displayHistory
        objSrchScreen.SetSearchTermHeaderText("Recent Searches:")
        objSrchScreen.SetSearchButtonText("search")
        objSrchScreen.SetClearButtonText("clear history")
        objSrchScreen.SetClearButtonEnabled(True) 'defaults to true
        objSrchScreen.SetSearchTerms(arrHistory)
    else
        objSrchScreen.SetSearchTermHeaderText("Suggestions:")
        objSrchScreen.SetSearchButtonText("search")
        objSrchScreen.SetClearButtonEnabled(False)
    endif 
    
    while isDone = false
        msg = wait(0, objSrchScreen.GetMessagePort()) 
        if type(msg) = "roSearchScreenEvent"
            if msg.isScreenClosed()
                print "screen closed"
                isDone = true
            else if msg.isCleared()
                print "search terms cleared"
                arrHistory.Clear()
            else if msg.isPartialResult()
                print "partial search: "; msg.GetMessage()
                if not displayHistory
                    objSrchScreen.SetSearchTerms((msg.GetMessage()))
                endif
            else if msg.isFullResult()
                print "full search: "; msg.GetMessage()
                arrHistory.Push(msg.GetMessage())
                if displayHistory
                    objSrchScreen.AddSearchTerm(msg.GetMessage())
                end if
                isDone = true
			 ShowAllListings(msg.GetMessage())
            else
                print "Unknown event: "; msg.GetType(); " msg: ";sg.GetMessage()
            endif
        endif
    endwhile 
    
End Sub

REM ******************************************************
REM
REM
REM
REM ******************************************************
Sub setSlideShow()
    port = CreateObject("roMessagePort")
    springBoard = CreateObject("roSpringboardScreen")
    springBoard.SetMessagePort(port)
    ' Set up screen...
 
    springBoard.Show()
    
    While True
        message = wait(0, port)
        If message.isScreenClosed() Then
            Exit While
        Else If message.isButtonPressed() Then
            ' Process menu items...
        End If
    End While
    ' Returning destroys the 'springBoard' variable, which closes the
    ' springboard screen, and reveals the poster screen again.
End Sub





REM ******************************************************
REM
REM DisplaySetup2
REM
REM ******************************************************
Function DisplaySetup2(port as object)
	slideshow = CreateObject("roSlideShow")
	slideshow.SetMessagePort(port)
	slideshow.SetUnderscan(5.0)      ' shrink pictures by 5% to show a little bit of border (no overscan)
	slideshow.SetBorderColor("#6b4226")
	slideshow.SetMaxUpscale(8.0)
	slideshow.SetDisplayMode("best-fit")
	slideshow.SetPeriod(6)
	slideshow.Show()
	return slideshow
End Function

REM ******************************************************
REM
REM DisplaySlideShow2
REM
REM ******************************************************
Sub DisplaySlideShow2(slideshow, photolist, mport)

     print "in DisplaySlideShow"
     slideshow.SetContentList(photolist)
         btn_more_from_author = 0
         btn_similar          = 1
         btn_bookmark         = 2
         btn_hide             = 3
     
     waitformsg:
     	msg = wait(0, mport)
     	print "DisplaySlideShow: class of msg: ";type(msg); " type:";msg.gettype()
     	'for each x in msg:print x;"=";msg[x]:next
     	if msg <> invalid then							'invalid is timed-out
     		if type(msg) = "roSlideShowEvent" then
         		if msg.isScreenClosed() then
     	    		return
         		else if msg.isButtonPressed() then
                     print "Menu button pressed: " + Stri(msg.GetIndex())
                     'example button usage during pause:
                     'if msg.GetIndex() = btn_hide slideshow.ClearButtons()
         		else if msg.isPlaybackPosition() then
     	    		onscreenphoto = msg.GetIndex()
     		    	print "slideshow display: " + Stri(msg.GetIndex())
         		else if msg.isRemoteKeyPressed() then
         			print "Button pressed: " + Stri(msg.GetIndex())
         		else if msg.isRequestSucceeded() then
     	    		print "preload succeeded: " + Stri(msg.GetIndex())
         		else if msg.isRequestFailed() then
         			print "preload failed: " + Stri(msg.GetIndex())
         		else if msg.isRequestInterrupted() then
         			print "preload interrupted" + Stri(msg.GetIndex())
         		else if msg.isPaused() then
                     print "paused"
                     'example button usage during pause:
                     'buttons will only be shown in when the slideshow is paused
                     'slideshow.AddButton(btn_more_from_author, "more photos from this author")
                     'slideshow.AddButton(btn_similar, "similar images")
                     'slideshow.AddButton(btn_bookmark, "mark as favorite")
                     'slideshow.AddButton(btn_hide, "hide buttons")
         		else if msg.isResumed() then
                     print "resumed"
                     'example button usage during pause:
                     'slideshow.ClearButtons()
                 end if
             end if
     	end if
     	goto waitformsg
End Sub


